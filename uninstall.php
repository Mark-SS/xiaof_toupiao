<?php
global $_W;
$sql = "
drop table if exists " . tablename('ims_xiaof_relation') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_acid') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_draw') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_drawlog') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_log') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_manage') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_pic') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_rule') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_safe') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_setting') . " ;
drop table if exists " . tablename('ims_xiaof_toupiao_smslog') . ";
";
pdo_query($sql);