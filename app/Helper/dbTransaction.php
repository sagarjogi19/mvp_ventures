<?php

function begin()
{
    \DB::beginTransaction();
}

function commit()
{
    \DB::commit();
}

function rollback()
{
    \DB::rollBack();
}
?>