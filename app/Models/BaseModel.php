<?php
namespace App\Models;

use App\Helpers\VisitorHelper;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    use SoftDeletes;
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    protected $useLog = true;
    public $request;
    public $method;
    public $rawData;
    protected $rules = [];
    // protected $appends = ["total_data"];
    protected $label;
    public $fails = true;
    protected $hiddenField = [];

    public $errors;
    protected $perPage = 10;
    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    protected $fillable;
    const STATUS = 'status';
    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'deleted_at';

    private $_data;

    
    public function __construct(Array $attributes=[],Request $request = null)
    {
        
        if ($request!=null) {
            $this->request = $request;
        } else {
            $this->request = request();
        }
        parent::__construct($attributes);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            // $model->created_by = Auth::id();
            // $model->updated_by = Auth::id();
            // $model->DELETED_AT = $model->DELETED_AT ? $model->DELETED_AT :  false;
            // $model->status = $model->status || $model->status==0 || $model->status=="0" ? $model->status : 1;
        });

        self::created(function($model){
            // $req = request();
            // if ($model->useLog) {
            //     VisitorHelper::visitCms($req, $model->getTable(), "Create ".$model->getTable());
            // }
        });
        self::deleted(function($model){
            // $req = request();
            // if ($model->useLog) {
            //     VisitorHelper::visitCms($req, $model->getTable(), "Delete ".$model->getTable());
            // }
        });
        self::updated(function($model){
            // $req = request();
            // if ($model->useLog) {
            //     VisitorHelper::visitCms($req, $model->getTable(), "Update ".$model->getTable());
            // }
        });
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getFillable($forLoad = false)
    {
        if ($this->fillable) {
            return $this->fillable;
        }
        $arr = Schema::getColumnListing($this->getTable());
        $del_val = [self::CREATED_AT, self::UPDATED_AT, self::DELETED_AT, $this->primaryKey];
        foreach ($del_val as $key => $value) {
            if (($key = array_search($value, $arr)) !== false) {
                unset($arr[$key]);
            }
        }
        
        if ($forLoad) {
            return $arr;
        }
        return array_diff($arr, $this->hiddenField);
    }
    
    public function scopeOrdered($query)
    {
        $qu = $this->request->query();
        unset($qu['page']);
        if (count($qu)==0) {
            return $query->orderBy($this->getTable() . '.' . self::UPDATED_AT, 'DESC');
        }
        return $query;
    }
    
    public function scopeSearch($query, String $key, $col = "name", $hasSearch=null)
    {
        if ($hasSearch!=null) {
            
            if (is_array($col)) {
                foreach ($col as $idx =>  $value) {
                    if ($idx==0) {
                        $query = $query->whereHas($hasSearch, function($q) use($key,$value) {
                            $q->where($value, 'like', '%' . $key . '%');
                        });
                    } else {
                        $query = $query->whereHas($hasSearch, function($q) use($key,$value) {
                            $q->orWhere($value, 'like', '%' . $key . '%');
                        });
                    }
                }
                return $query;
            }
            return $query->whereHas($hasSearch, function($q) use($col, $key){
                $q->where($col, 'like', '%' . $key . '%');
            });
        }
        if (is_array($col)) {
            foreach ($col as $idx =>  $value) {
                if ($idx==0) {
                    $query = $query->where($value, 'like', '%' . $key . '%');
                } else {
                    $query = $query->orWhere($value, 'like', '%' . $key . '%');
                }
            }
            return $query;
        }
        return $query->where($col, 'like', '%' . $key . '%');
    }

    public function scopeSearchAny($query, String $keyword, $col)
    {
        list($col1, $col2) = $col;
        $query->where($col1, 'like', '%' . $keyword . '%')
           ->orWhere($col2, 'like', '%' . $keyword . '%');
    }

    public function rules()
    {   
        return $this->rules;
    }

    public function validate()
    {
        $rawData = (Array) $this->_data;
        $rawData = array_merge($this->getAttributes());
        $validator = Validator::make($rawData, $this->rules(), $this->message());
        $this->fails = $validator->fails();
        $this->errors = $validator;
    }

    public function scopeDropdown($query, String $primaryKey = "id", String $label="name")
    {
        $arr = [];
        $data = $query->get();
        foreach ($data as $key => $value) {
            $arr[$value[$primaryKey]] = $value[$label];
        }
        return $arr;
    }
}
