<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Column extends Model implements Sortable
{
    use SoftDeletes;
    use SortableTrait;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'name',
        'type',
        'foreign_table_id',
        'foreign_column_id',
        'on_delete',
        'length',
        'default',
        'attribute',
        'nullable',
        'unique',
        'unsigned',
        'primary',
        'index',
        'auto_increament',
        'mme_type',
        'comment',
        'status',

    ];
    public function buildSortQuery()
    {
        return static::query()->where('table_id', $this->table_id);
    }
    public function database()
    {
        return $this->belongsTo(Database::class);
    }
    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
    public function foreign_table()
    {
        return $this->belongsTo(Table::class, 'foreign_table_id');
    }
    public function foreign_column()
    {
        return $this->belongsTo(Column::class, 'foreign_column_id');
    }
    public static function get_laravel_types()
    {
        return [
            'bigIncrements' => 'bigIncrements',
            'bigInteger' => 'bigInteger',
            'binary' => 'binary',
            'boolean' => 'boolean',
            'char' => 'char',
            'date' => 'date',
            'dateTime' => 'dateTime',
            'dateTimeTz' => 'dateTimeTz',
            'decimal' => 'decimal',
            'double' => 'double',
            'enum' => 'enum',
            'float' => 'float',
            'geometry' => 'geometry',
            'geometryCollection' => 'geometryCollection',
            'increments' => 'increments',
            'integer' => 'integer',
            'ipAddress' => 'ipAddress',
            'json' => 'json',
            'jsonb' => 'jsonb',
            'lineString' => 'lineString',
            'longText' => 'longText',
            'macAddress' => 'macAddress',
            'mediumIncrements' => 'mediumIncrements',
            'mediumInteger' => 'mediumInteger',
            'mediumText' => 'mediumText',
            'morphs' => 'morphs',
            'uuidMorphs' => 'uuidMorphs',
            'multiLineString' => 'multiLineString',
            'multiPoint' => 'multiPoint',
            'multiPolygon' => 'multiPolygon',
            'nullableMorphs' => 'nullableMorphs',
            'nullableUuidMorphs' => 'nullableUuidMorphs',
            'nullableTimestamps' => 'nullableTimestamps',
            'point' => 'point',
            'polygon' => 'polygon',
            'rememberToken' => 'rememberToken',
            'set' => 'set',
            'smallIncrements' => 'smallIncrements',
            'smallInteger' => 'smallInteger',
            'softDeletes' => 'softDeletes',
            'softDeletesTz' => 'softDeletesTz',
            'string' => 'string',
            'text' => 'text',
            'time' => 'time',
            'timeTz' => 'timeTz',
            'timestamp' => 'timestamp',
            'timestampTz' => 'timestampTz',
            'timestamps' => 'timestamps',
            'timestampsTz' => 'timestampsTz',
            'tinyIncrements' => 'tinyIncrements',
            'tinyInteger' => 'tinyInteger',
            'unsignedBigInteger' => 'unsignedBigInteger',
            'unsignedDecimal' => 'unsignedDecimal',
            'unsignedInteger' => 'unsignedInteger',
            'unsignedMediumInteger' => 'unsignedMediumInteger',
            'unsignedSmallInteger' => 'unsignedSmallInteger',
            'unsignedTinyInteger' => 'unsignedTinyInteger',
            'uuid' => 'uuid',
            'year' => 'year',
            'foreign' => 'foreign',
        ];
    }
    public static function get_laravel_default_type()
    {
        return 'string';
    }
    public static function get_mysql_types()
    {
        return [
            'TINYINT' => 'TINYINT',
            'SMALLINT' => 'SMALLINT',
            'MEDIUMINT' => 'MEDIUMINT',
            'INT' => 'INT',
            'BIGINT' => 'BIGINT',
            'DECIMAL' => 'DECIMAL',
            'FLOAT' => 'FLOAT',
            'DOUBLE' => 'DOUBLE',
            'REAL' => 'REAL',
            'BIT' => 'BIT',
            'BOOLEAN' => 'BOOLEAN',
            'SERIAL' => 'SERIAL',
            'DATE' => 'DATE',
            'DATETIME' => 'DATETIME',
            'TIMESTAMP' => 'TIMESTAMP',
            'TIME' => 'TIME',
            'YEAR' => 'YEAR',
            'CHAR' => 'CHAR',
            'VARCHAR' => 'VARCHAR',
            'TINYTEXT' => 'TINYTEXT',
            'TEXT' => 'TEXT',
            'MEDIUMTEXT' => 'MEDIUMTEXT',
            'LONGTEXT' => 'LONGTEXT',
            'BINARY' => 'BINARY',
            'VARBINARY' => 'VARBINARY',
            'TINYBLOB' => 'TINYBLOB',
            'MEDIUMBLOB' => 'MEDIUMBLOB',
            'BLOB' => 'BLOB',
            'LONGBLOB' => 'LONGBLOB',
            'ENUM' => 'ENUM',
            'SET' => 'SET',
            'GEOMETRY' => 'GEOMETRY',
            'POINT' => 'POINT',
            'LINESTRING' => 'LINESTRING',
            'POLYGON' => 'POLYGON',
            'MULTIPOINT' => 'MULTIPOINT',
            'MULTILINESTRING' => 'MULTILINESTRING',
            'MULTIPOLYGON' => 'MULTIPOLYGON',
            'GEOMETRYCOLLECTION' => 'GEOMETRYCOLLECTION',
            'FOREIGN' => 'FOREIGN',
        ];
    }
    public static function get_mysql_default_type()
    {
        return 'VARCHAR';
    }
    public static function get_on_deletes()
    {
        return [
            'CASCADE' => 'CASCADE',
            'RESTRICT' => 'RESTRICT',
        ];
    }
    public static function get_default_on_delete()
    {
        return 'CASCADE';
    }
    public static function get_attributes()
    {
        return [
            'BINARY' => 'BINARY',
            'UNSIGNED' => 'UNSIGNED',
            'UNSIGNED ZEROFILL' => 'UNSIGNED ZEROFILL',
        ];
    }
    public static function get_mme_types()
    {
        return [
            'image/jpg' => 'image/jpg',
            'text/plain' => 'text/plain',
            'application/octetstream' => 'application/octetstream',
            'image/png' => 'image/png',
            'text/octetstream' => 'text/octetstream',
        ];
    }
}
