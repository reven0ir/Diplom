<?php

namespace PHPFramework;

abstract class Model
{

    protected string $table = '';
    protected array $fillable = [];
    public array $attributes = [];
    protected array $rules = [];
    protected array $labels = [];
    protected array $data_items = [];

    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'int', 'email', 'unique', 'file', 'ext', 'size', 'match'];
    protected array $messages = [
        'required' => ':fieldname: field is required',
        'min' => ':fieldname: field must be a minimun :rulevalue: characters',
        'max' => ':fieldname: field must be a maximum :rulevalue: characters',
        'int' => ':fieldname: field must be an integer',
        'email' => 'Not valid email',
        'unique' => ':fieldname: is already taken',
        'file' => ':fieldname: field is required',
        'ext' => 'File :fieldname: extension does not match. Allowed :rulevalue:',
        'size' => 'File :fieldname: is too large. Allowed :rulevalue: bytes',
        'match' => ':fieldname: field must match :rulevalue: field',
    ];

    public function save(): false|string
    {
        $fields_keys = array_keys($this->attributes);
        $fields = array_map(fn($field) => "`{$field}`", $fields_keys);
        $fields = implode(',', $fields);

        $values_placeholders = array_map(fn($v) => ":{$v}", $fields_keys);
        $values_placeholders = implode(',', $values_placeholders);
        $query = "INSERT INTO {$this->table} ($fields) VALUES ($values_placeholders)";
        db()->query($query, $this->attributes);
        return db()->getInsertId();
    }

    public function update()
    {
        if (!isset($this->attributes['id'])) {
            return false;
        }

        $fields = '';
        foreach ($this->attributes as $k => $v) {
            if ($k == 'id') {
                continue;
            }
            $fields .= "`{$k}`=:{$k},";
        }
        $fields = rtrim($fields, ',');
        $query = "UPDATE {$this->table} SET {$fields} WHERE `id`=:id";
        db()->query($query, $this->attributes);
        return db()->rowCount();
    }

    public function delete(int $id): int
    {
        db()->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
        return db()->rowCount();
    }

    public function loadData(): void
    {
        $data = request()->getData();
        foreach ($this->fillable as $v) {
            if (isset($data[$v])) {
                $this->attributes[$v] = $data[$v];
            } else {
                $this->attributes[$v] = '';
            }
        }
    }

    public function validate($data = [], $rules = []): bool
    {
        if (!$data) {
            $data = $this->attributes;
        }
        if (!$rules) {
            $rules = $this->rules;
        }
        $this->data_items = $data;
        foreach ($data as $fieldname => $value) {
            if (isset($rules[$fieldname])) {
                $this->check([
                    'fieldname' => $fieldname,
                    'value' => $value,
                    'rules' => $rules[$fieldname],
                ]);
            }
        }
        return !$this->hasErrors();
    }

    protected function check(array $field): void
    {
        foreach ($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list)) {
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError(
                        $field['fieldname'],
                        str_replace(
                            [':fieldname:', ':rulevalue:'],
                            [$this->labels[$field['fieldname']] ?? $field['fieldname'], $rule_value],
                            $this->messages[$rule]
                        )
                    );
                }
            }
        }
    }

    protected function addError($fieldname, $error): void
    {
        $this->errors[$fieldname][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function listErrors(): string
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $field_errors) {
            foreach ($field_errors as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';
        return $output;
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function required($value, $rule_value): bool
    {
        return !empty(trim($value));
    }

    protected function min($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function int($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    protected function email($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function match($value, $rule_value): bool
    {
        return $value === $this->data_items[$rule_value];
    }

    protected function unique($value, $rule_value): bool
    {
        $data = explode(':', $rule_value);
        if (str_contains($data[1], ',')) {
            $data_fields = explode(',', $data[1]); // 0 - slug, 1 - id
            return !(db()->query("SELECT {$data_fields[0]} FROM {$data[0]} WHERE {$data_fields[0]} = ? AND {$data_fields[1]} != ?", [$value, $this->data_items[$data_fields[1]]])->getColumn());
        }
        return !(db()->query("SELECT {$data[1]} FROM {$data[0]} WHERE {$data[1]} = ?", [$value])->getColumn());
    }

    protected function file($value, $rule_value): bool
    {
        if (isset($value['error']) && is_array($value['error'])) {
            foreach ($value['error'] as $file_error) {
                if ($file_error !== 0) {
                    return false;
                }
            }
        } elseif (isset($value['error']) && $value['error'] !== 0) {
            return false;
        }
        return true;
    }

    protected function ext($value, $rule_value): bool
    {
        // массив файлов
        if (is_array($value['name'])) {
            if (empty($value['name'][0])) {
                return true;
            }

            for ($i = 0; $i < count($value['name']); $i++) {
                $file_ext = get_file_ext($value['name'][$i]);
                $allowed_exts = explode('|', $rule_value);
                if (!in_array($file_ext, $allowed_exts)) {
                    return false;
                }
            }
            return true;
        }

        // один файл
        if (empty($value['name'])) {
            return true;
        }
        $file_ext = get_file_ext($value['name']);
        $allowed_exts = explode('|', $rule_value);
        return in_array($file_ext, $allowed_exts);
    }

    protected function size($value, $rule_value): bool
    {
        if (is_array($value['size'])) {
            if (empty($value['size'][0])) {
                return true;
            }
            for ($i = 0; $i < count($value['size']); $i++) {
                if ($value['size'][$i] > $rule_value) {
                    return false;
                }
            }
            return true;
        }

        if (empty($value['size'])) {
            return true;
        }
        return $value['size'] <= $rule_value;
    }

}