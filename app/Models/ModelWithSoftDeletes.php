<?php
namespace App\Models;

use App\Traits\ModelRulesTrait;
use App\Traits\SoftDeletesTrait;
use App\Traits\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

class ModelWithSoftDeletes extends Model
{
    use SoftDeletesTrait, RelationshipsTrait, ModelRulesTrait;

}