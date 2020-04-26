<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    const STATUS = [
        1 => ['label' => '未着手', 'class' => 'label-danger', 'class2' => 'text-danger'],
        2 => ['label' => '着手中', 'class' => 'label-info', 'class2' => 'text-info'],
        3 => ['label' => '完了', 'class' => '', 'class2' => 'text-muted'],
    ];

    public function getStatusLabelAttribute() {
        $status = $this->attributes['status'];

        if(!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    public function getStatusClassAttribute() {
        $status = $this->attributes['status'];

        if(!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }

    public function getStatusClass2Attribute() {
        $status = $this->attributes['status'];

        if(!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class2'];
    }

    public function getFormattedDueDateAttribute() {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('Y/m/d');
    }



}
