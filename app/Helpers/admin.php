<?php


use App\Models\Themes;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

if (!function_exists('admin_path')) {
    function admin_path($path)
    {
        return asset("storage/admin/" . $path);
    }
}

if (!function_exists('pagination_count')) {
    function pagination_count()
    {
        return 25;
    }
}

if (!function_exists('slug')) {
    function slug($value)
    {

        if (is_null($value)) {
            return "";
        }
        $value = trim($value, " ");
        $value = mb_strtolower($value, "UTF-8");;
        $value = preg_replace('/\s+/', ' ', $value);
        $value = str_replace("/", '-', $value);
        $value = str_replace(" ", '-', $value);
        return $value;
    }
}

if (!function_exists('removeHTML')) {
    function removeHTML($content)
    {
        $result = filter_var($content, FILTER_SANITIZE_STRING);
        $result = trim($result);
        $result = str_replace('&nbsp;', '', $result);
        return $result;
    }
}

if (!function_exists('ImageValidate')) {
    function ImageValidate()
    {
        return "image|mimes:jpeg,png,jpg,gif,svg|max:3000";
    }
}

if (!function_exists('getLevel')) {
    function getLevel($item)
    {
        $parent = $item->parent;
        if ($parent == null) {
            return 1;
        } else {
            return $parent->level + 1;
        }
    }
}

if (!function_exists('updateLevel')) {
    function updateLevel($parent)
    {
        if ($parent == null) {
            return 1;
        } else {
            return $parent->level + 1;
        }
    }
}

if (!function_exists('getPathTree')) {
    function getPathTree($item)
    {
        $ids = [];
        getParent($item, $ids);
        return $ids;
    }
}

if (!function_exists('getParent')) {
    function getParent($child, &$ids)
    {
        if (@$child->parent_id != null) {
            $ids[] = $child->parent->id;
            return getParent(@$child->parent, $ids);
        }
    }
}

if (!function_exists('getAdminRoutes')) {
    function getAdminRoutes()
    {
        $routeCollection = Route::getRoutes();
        $routes = [];
        $permissions = [];
        foreach ($routeCollection as $value) {
            $routes[] =  $value->getName();
        }
        $routes = array_filter($routes);
        foreach ($routes as $route) {
            if (str_contains($route, "admin") == true) {
                $permissions[] = $route;
            }
        }
        return $permissions;
    }
}

if (!function_exists('transPermission')) {
    function transPermission($val)
    {
        $val = str_replace('admin.', '', $val);
        $val = str_replace('.', ' ', $val);
        $val = str_replace('-', ' ', $val);
        return  $val;
    }
}

if (!function_exists('dashboard_themes')) {
    function dashboard_themes($key = null)
    {
        $theme = json_decode(@Themes::query()->where('key', 'dashboard')->get()->first()->value);
        return @$theme->$key;
    }
}

if (!function_exists('login_dashboard_themes')) {
    function login_dashboard_themes($key = false)
    {
        $theme = json_decode(@Themes::query()->where('key', 'login_dashboard')->get()->first()->value);
        return @$theme->$key;
    }
}

if (!function_exists('get_dashboard_themes')) {
    function get_dashboard_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'dashboard')->get()->first()->value);
        return @$theme;
    }
}

if (!function_exists('get_login_dashboard_themes')) {
    function get_login_dashboard_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'login_dashboard')->get()->first()->value);
        return @$theme;
    }
}

if (!function_exists('get_site_themes')) {
    function get_site_themes()
    {
        $theme = json_decode(@Themes::query()->where('key', 'site')->get()->first()->value);
        return @$theme;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($file, $path = '')
    {
        $imageName = time() . '.' . $file->extension();
        return "attachments" . "/" . $file->store($path, 'attachment');
    }
}

if (!function_exists('arrang_records')) {
    function arrang_records($items, $search_ids = [])
    {
        $ids = [];
        if ($search_ids != []) $parents = $items->whereIn('id', $search_ids);
        else $parents = $items->where('parent_id', null);
        foreach ($parents as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $items);
        }
        return $ids;
    }
}

if (!function_exists('arrange_child')) {
    function arrange_child($parent, &$ids, $items = null)
    {
        $children =  $items->where('parent_id', $parent->id);
        foreach ($children as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $items);
        }
    }
}

if (!function_exists('get_childs_id')) {
    function get_childs_id($items,  $tree)
    {
        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item->id;
            arrange_child($item, $ids, $tree);
        }
        return $ids;
    }
}

if (!function_exists('update_childs_level')) {
    function update_childs_level($parent, $items = null)
    {
        $childsModel = [];
        get_childs($parent, $childsModel,  $items);
        if ($childsModel) {
            foreach ($childsModel as $childupdate) {
                if (isset($childupdate->level)) {
                    $childupdate->level =  updateLevel(@$childupdate->parent);
                    $childupdate->save();
                }
            }
        }

        return $childsModel;
    }
}

if (!function_exists('get_childs')) {
    function get_childs($parent, &$childsModel,  $items = null)
    {
        foreach ($parent->children as $item) {
            $childsModel[] = $item;
            arrange_child($item, $childsModel,  $items);
        }
    }
}

if (!function_exists('syncPermisions')) {
    function syncPermisions($model = null)
    {
        $routes = array_unique(array_filter(getAdminRoutes()));
        foreach ($routes as $route) {
            Permission::firstOrCreate([
                'name' => $route,
                'guard_name' => 'web',
            ]);
        }
    }
}


if (!function_exists('signature')) {
    function signature()
    {
        $shaString  = '';
        // array request
        $arrData    = array(
            'command'            => 'PURCHASE',
            'access_code'        => 'SILgpo7pWbmzuURp2qri',
            'merchant_identifier' => 'MxvOupuG',
            'merchant_reference' => 'Test010',
            'amount'             => '1000',
            'currency'           => 'USD',
            'language'           => 'en',
            'customer_email'  => 'test@gmail.com',
        );
        // sort an array by key
        ksort($arrData);
        foreach ($arrData as $key => $value) {
            $shaString .= "$key=$value";
        }
        // make sure to fill your sha request pass phrase
        $shaString = "YOUR_SHA_REQUEST_PASSPHRASE" . $shaString . "YOUR_SHA_REQUEST_PASSPHRASE";
        $signature = hash("sha256", $shaString);
        // your request signature
        return $signature;
    }
}
