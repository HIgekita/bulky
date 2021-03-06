<?php
/**
 * This file is part of Bulky.
 *
 * (c) Yuya Takeyama
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Query builder for MySQL's bulk insertion query.
 *
 * @author Yuya Takeyama
 */
class Yuyat_Bulky_DbAdapter_PdoMysqlAdapter_QueryBuilder
{
    public function build($table, array $columns, array $records)
    {
        $query = "INSERT INTO `{$table}` " .
            "{$this->toColumnList($columns)} VALUES ";
        $query .= $this->toValueLists($records);

        return $query;
    }

    private function toColumnList(array $columns)
    {
        return
            '(' .
            join(', ',
                array_map(array($this, 'appendBackQuote'), $columns)
            ) .
            ')';
    }

    private function appendBackQuote($str)
    {
        return "`{$str}`";
    }

    private function toValueLists(array $records)
    {
        return join(', ', array_map(array($this, 'toValueList'), $records));
    }

    private function toValueList(array $record)
    {
        return '(' . join(', ', array_map(array($this, 'toPlaceHolder'), $record)) . ')';
    }

    private function toPlaceHolder()
    {
        return '?';
    }
}
