<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace wskeee\rbac;

/**
 * Description of RbacName
 *
 * @author Administrator
 */
class RbacName {
    /** 管理员 */
    const ROLE_ADMIN = 'r_admin';
    /** 接洽人 */
    const ROLE_CONTACT = 'r_contact';
    /** 游客 */
    const ROLE_GUEST = 'r_guest';
    /** 多媒体制作师 Multimedia Production */
    const ROLE_MP = 'r_mp';
    /** 多媒体制作组长 Multimedia Production leader */
    const ROLE_MP_LEADER = 'r_mp_leader';
    /** 新闻事件管理员 */
    const ROLE_NEW_PUBLISHER = 'r_new_publisher';
    /** 摄影组长 */
    const ROLE_SHOOT_LEADER = 'r_shoot_leader';
    /** 摄影师 */
    const ROLE_SHOOT_MAN = 'r_shoot_man';
    /** 编导 */
    const ROLE_WD = 'r_wd';
    /** 编导组长 */
    const ROLE_WD_LEADER = 'r_wd_leader';
    /** 老师 */
    const ROLE_TEACHERS = 'r_teachers';
    
    
    
    /** 平台新闻发布 */
    const PERMSSIONT_NEW_PUBLISH = 'p_new_publish';
    /** 权限管理 */
    const PERMSSIONT_RBAC_ADMIN = 'p_rbac_admin';
    /** 拍摄-管理 */
    const PERMSSIONT_SHOOT_ADMIN = 'p_shoot_admin';
    /** 拍摄-摄影师分派 */
    const PERMSSIONT_SHOOT_ASSIGN = 'p_shoot_assign';
    /** 拍摄-取消预约 */
    const PERMSSIONT_SHOOT_CANCEL = 'p_shoot_cancel';
    /** 拍摄-创建预约 */
    const PERMSSIONT_SHOOT_CREATE = 'p_shoot_create';
    /** 拍摄-评价 */
    const PERMSSIONT_SHOOT_APPRAISE = 'p_shoot_appraise';
    /** 拍摄-评价【接洽人】【摄影师】特有*/
    const PERMSSIONT_SHOOT_OWN_APPRAISE = 'p_shoot_own_appraise';
    /** 拍摄-查看预约 */
    const PERMSSIONT_SHOOT_INDEX = 'p_shoot_index';
    /** 拍摄-取消自己创建的预约 */
    const PERMSSIONT_SHOOT_OWN_CANCEL = 'p_shoot_own_cancel';
    /** 拍摄-更新自己创建的预约 */
    const PERMSSIONT_SHOOT_OWN_UPDATE = 'p_shoot_own_update';
    /** 拍摄-更新预约 */
    const PERMSSIONT_SHOOT_UPDATE = 'p_shoot_update';
}
