<?php

Route::group(['namespace' => 'Hamahang', 'prefix' => 'Page', 'middleware' => ['dynamic_permission:pgs.desktop.hamahang']], function ()
{
    require(__DIR__ . '/helper/HamahangPagesRoutes/Get/getTasks.php');
    require(__DIR__ . '/helper/HamahangPagesRoutes/Get/getProcess.php');
    require(__DIR__ . '/helper/HamahangPagesRoutes/Get/getProjects.php');
});