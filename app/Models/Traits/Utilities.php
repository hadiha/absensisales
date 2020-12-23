<?php
namespace App\Models\Traits;

use Carbon\Carbon;

trait Utilities
{
    public function lpad($field, $length = 2, $padder = ' ')
    {
        return str_pad($this->$field, $length, $padder, STR_PAD_LEFT);
    }

    public function readMoreRaw($value, $maxLength = 150)
    {
        $return = $value;
        if (strlen($value) > $maxLength) {
            $return   = substr($value, 0, $maxLength);
            $readmore = substr($value, $maxLength);

            $return .= '<a href="javascript: void(0)" class="read-more" onclick="$(this).parent().find(\'.read-more-cage\').show(); $(this).hide()">&nbsp;&nbsp;read more</a>';

            $readless = '<a href="javascript: void(0)" class="read-less" onclick="$(this).parent().parent().find(\'.read-more\').show(); $(this).parent().hide()">&nbsp;&nbsp;read less</a>';

            $return = "<span>{$return}<span style='display: none' class='read-more-cage'>{$readmore} {$readless}</span></span>";
        }

        return $return;
    }

    public function readMoreText($field, $maxLength = 150)
    {
        $value = $this->$field;
        return utf8_decode($this->readMoreRaw($value, $maxLength));
    }

    public static function options($display, $id = 'id', $params = [], $default=null)
    {
        $q = static::select('*');

        $params = array_merge([
            'valuePrefix' => '',
        ], $params);

        if (isset($params['filters'])) {
            foreach ($params['filters'] as $key => $value) {
                if (is_numeric($key) && is_callable($value)) {
                    $q = $q->where($value);
                } else {
                    $q = $q->where($key, $value);
                }
            }
        }

        if (isset($params['orders'])) {
            foreach ($params['orders'] as $key => $value) {
                if (is_numeric($key)) {
                    $key   = $value;
                    $value = 'asc';
                }

                $q = $q->orderBy($key, $value);
            }
        }

        $r = [];

        $ret = '';
        if ($default !== false) {
            if($default === null){
                $default = '(Pilih Salah Satu)';
            }
            $ret = '<option value="">' . $default . '</option>';
        }

        if (is_string($display)) {
            $q = $q->orderBy($display, 'asc');
            $r = $q->pluck($display, $id);

            foreach ($r as $i => $v) {
                $i = $params['valuePrefix'] . $i;
                $checked = isset($params['selected']) &&
                           (is_array($params['selected']) ? in_array($i, $params['selected']) : $i == $params['selected']);
                if ($checked) {
                    $ret .= '<option value="' . $i . '" selected>' . $v . '</option>';
                } else {
                    $ret .= '<option value="' . $i . '">' . $v . '</option>';
                }
            }
        } elseif (is_callable($display)) {
            $r = $q->get();

            foreach ($r as $d) {
                $i = $params['valuePrefix'] . $d->$id;
                $checked = isset($params['selected']) &&
                           (is_array($params['selected']) ? in_array($i, $params['selected']) : $i == $params['selected']);
                if ($checked) {
                    $ret .= '<option value="' . $i . '" selected>' . $display($d) . '</option>';
                } else {
                    $ret .= '<option value="' . $i . '">' . $display($d) . '</option>';
                }
            }
        }
        return $ret;
    }

    public static function queryRaw($query)
    {
        $q = static::select('*');

        $q->from(\DB::raw("($query) as tbl"));

        return $q->get();
    }
}
