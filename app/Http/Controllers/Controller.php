<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Entrust;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $breadcrumb = ["Home" => "#"];
    private $link = "";
    private $perms = "";
    private $title = "Title";
    private $subtitle = " ";
    private $tableStruct = [];
    private $modalSize = "mini";
    private $action = "create";
    private $jalur = "academic";
    private $appClose = false;

    public function setBreadcrumb($value=[])
    {
        $this->breadcrumb = $value;
    }

    public function pushBreadCrumb($value=[])
    {
        array_push($this->breadcrumb, $value);
    }

    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    public function setTableStruct($value=[])
    {
        $this->tableStruct = $value;
    }

    public function getTableStruct()
    {
        return $this->tableStruct;
    }

    public function setTitle($value="")
    {
        $this->title = $value;
    }

    public function setAppClose($value="")
    {
        $this->appClose = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setSubtitle($value="")
    {
        $this->subtitle = $value;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setLink($value="")
    {
        $this->link = $value;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setPerms($value="")
    {
        $this->perms = $value;
    }

    public function getPerms()
    {
        return $this->perms;
    }

    public function getAppClose()
    {
        return $this->appClose;
    }

    public function setModalSize($value="mini")
    {
        $this->modalSize = $value;
    }

    public function getModalSize()
    {
        return $this->modalSize;
    }

    public function setAction($value="create")
    {
        $this->action = $value;
    }

    public function setJalur($value="academic")
    {
        $this->jalur = $value;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function render($view, $additional=[])
    {
        $data = [
            'breadcrumb' => $this->breadcrumb,
            'title'      => $this->title,
            'subtitle'   => $this->subtitle,
            'pageUrl'    => $this->link,
            'pagePerms'  => $this->perms,
            'modalSize'  => $this->modalSize,
            'tableStruct'=> $this->tableStruct,
            'mockup'     => true,
            'action'     => $this->action,
            'jalur'      => $this->jalur,
            'appClose'      => $this->appClose,
        ];

        if($this->perms != '' && !Entrust::can($this->perms.'-view')){
            return abort('404');
        }

        return view($view, array_merge($data, $additional));
    }

    public function makeButton($params = [])
    {
        $settings = [
            'id'    => '',
            'class'    => 'blue',
            'label'    => 'Button',
            'tooltip'  => '',
            'target'   => url('/'),
            'disabled' => '',
            'url' => '',
        ];

        $btn = '';
        $datas = '';
        $attrs = '';

        if (isset($params['datas'])) {
            foreach ($params['datas'] as $k => $v) {
                $datas .= " data-{$k}=\"{$v}\"";
            }
        }

        if (isset($params['attributes'])) {
            foreach ($params['attributes'] as $k => $v) {
                $attrs .= " {$k}=\"{$v}\"";
            }
        }

        switch ($params['type']) {
            case "verifikasi":
                $settings['class']   = 'green icon delete';
                $settings['label']   = '<i class="check icon"></i>';
                $settings['tooltip'] = 'Verifikasi Data';
                
                $params  = array_merge($settings, $params);
                $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

                $btn = "<button type='button' onclick=\"verifikasiData('".$params['code']."', '".$params['url']."')\" {$datas}{$attrs}{$extends} class='ui mini {$params['class']} button' {$params['disabled']}>{$params['label']}</button>\n";
                break;
            case "delete":
                $settings['class']   = 'red icon delete';
                $settings['label']   = '<i class="trash icon"></i>';
                $settings['tooltip'] = 'Hapus Data';
                $settings['disabled'] = $this->perms != '' && !Entrust::can($this->perms.'-delete');
                
                $params  = array_merge($settings, $params);
                $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";
                $btn = "<button type='button' onclick=\"deleteData('".$params['url']."')\" 
                {$datas}{$attrs}{$extends} class='ui mini {$params['class']} ".($params['disabled'] ? 'disabled' : '')." button'>{$params['label']}</button>\n";
                break;
            case "edit":
                $settings['class']   = 'blue icon edit';
                $settings['label']   = '<i class="edit icon"></i>';
                $settings['tooltip'] = 'Ubah Data';
                
                $params  = array_merge($settings, $params);
                $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

                $btn = "<a href=\"{$params['url']}\" {$datas}{$attrs}{$extends} class='ui mini {$params['class']} button' {$params['disabled']}>{$params['label']}</a>\n";
                break;
            case "modal":
                $settings['onClick'] = '';
                $settings['class']   = 'blue icon edit';
                $settings['label']   = '<i class="edit icon"></i>';
                $settings['tooltip'] = 'Ubah Data';
                
                $params  = array_merge($settings, $params);
                $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

                $btn = "<button type='button' {$datas}{$attrs}{$extends} class='ui mini {$params['class']} ".($params['disabled'] ? 'disabled' : '')." button' {$params['disabled']} onclick='{$params['onClick']}'>{$params['label']}</button>\n";
                break;
            case "print":
                $settings['class']   = 'orange icon print';
                $settings['label']   = '<i class="print icon"></i>';
                $settings['tooltip'] = 'Print';
                
                $params  = array_merge($settings, $params);
                $extends = " data-content='{$params['tooltip']}' data-id='{$params['id']}'";

                $btn = "<button type='button' onclick=\"printPdf('".$params['id']."')\" {$datas}{$attrs}{$extends} class='ui mini {$params['class']} button' {$params['disabled']}>{$params['label']}</button>\n";
                break;
            case "url":
            default:
                $settings['onClick']   = '';
                $settings['class']   = 'blue icon';
                $settings['label']   = '<i class="eye icon"></i>';
                
                $params  = array_merge($settings, $params);
                $extends = '';
                if($params['tooltip'] != '')
                {
                    $extends = " data-content='{$params['tooltip']}'";
                }

                $btn = "<a href='{$params['url']}' {$datas}{$attrs}{$extends} class='ui mini {$params['class']} button {$params['disabled']}'  onclick='{$params['onClick']}'>{$params['label']}</a>\n";
        }

        return $btn;
    }
    
}
