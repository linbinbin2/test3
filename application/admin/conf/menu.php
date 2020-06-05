<?php
//  各模块菜单栏以及权限配置
// +----------------------------------------------------------------------
// | Author: liu
// +----------------------------------------------------------------------
$menu = array(	
    
	"admin"=>array(
		array(
            'name'=>'首页管理',
            'controller'=>'admin/users',
            // 'icon'=>'fa-user',
            'child'=>array(

                array(
                    'name'=>'轮播图管理',

                    'action'=>'admin/home/homePage',

                    "auth"=>array(
                        // array("name"=>'查看区域','action'=>"admin/home/addArticle"),
                        array("name"=>'添加','action'=>"admin/home/addHome"),
                        array("name"=>'删除','action'=>"admin/home/delHome"),
                        array("name"=>'修改','action'=>"admin/home/updateHome"),
                    )
				),
				array(
                    'name'=>'首页文章',

                    'action'=>'admin/home/homeContent',

                    "auth"=>array(
                        // array("name"=>'查看区域','action'=>"admin/home/addArticle"),
                        array("name"=>'添加','action'=>"admin/home/addContent"),
                        array("name"=>'删除','action'=>"admin/home/delContent"),
                        array("name"=>'修改','action'=>"admin/home/updateContent"),
                    )
                )
            )
        ),
        array(
            'name'=>'数据管理',
            'controller'=>'admin/users',
            // 'icon'=>'fa-user',
            'child'=>array(

                array(
                    'name'=>'查看数据',

                    'action'=>'admin/users/userList',

                    "auth"=>array(
                        array("name"=>'查看区域','action'=>"admin/area/addArticle"),
                        array("name"=>'添加','action'=>"admin/area/addArticle"),
                        array("name"=>'删除','action'=>"admin/area/delArticle"),
                        array("name"=>'修改','action'=>"admin/area/updateArticle"),
                    )
                )
            )
        ),

        array(
			'name'=>'金额管理',
	        'controller'=>'admin/Money',
	        // 'icon'=>'fa-user',
			'child'=>array(

				array(
					'name'=>'金额列表',

					'action'=>'admin/Money/moneylist',

	                "auth"=>array(
	                	array("name"=>'修改金额','action'=>"admin/Money/editMoney"),
	                )
			    )
			    
		    )
		    
		),

		array(
			'name'=>'订单管理',
	        'controller'=>'admin/User',
	        // 'icon'=>'fa-user',
			'child'=>array(

				array(
					'name'=>'订单列表',

					'action'=>'admin/Order/orderList',

	                "auth"=>array(
	                	array("name"=>'添加','action'=>"admin/Order/addOrder"),
	                	array("name"=>'删除','action'=>"admin/Order/delOrder"),
	                	array("name"=>'修改','action'=>"admin/Order/editOrder"),
	                )
			    )
			    
		    )
		    
		),

        array(
            'name'=>'类型管理',
            'controller'=>'admin/type',
            // 'icon'=>'fa-list',
            'child'=>array(

                array(
                    'name'=>'查看类型',

                    'action'=>'admin/type/typeList',

                    "auth"=>array(
                        array("name"=>'查看区域','action'=>"admin/area/addArticle"),
                        array("name"=>'添加','action'=>"admin/area/addArticle"),
                        array("name"=>'删除','action'=>"admin/area/delArticle"),
                        array("name"=>'修改','action'=>"admin/area/updateArticle"),
                    )
                ),

            )
        ),

        // array(
        //     'name'=>'地区管理',
        //     'controller'=>'admin/area',
        //     'icon'=>'fa-map',
        //     'child'=>array(

        //         array(
        //             'name'=>'查看城市',

        //             'action'=>'admin/area/areaList',

        //             "auth"=>array(
        //                 array("name"=>'查看区域','action'=>"admin/area/addArticle"),
        //                 array("name"=>'添加','action'=>"admin/area/addArticle"),
        //                 array("name"=>'删除','action'=>"admin/area/delArticle"),
        //                 array("name"=>'修改','action'=>"admin/area/updateArticle"),
        //             )
        //         ),
        //         // array(
        //         //     'name'=>'查看区域',

        //         //     'action'=>'admin/area/areaList',

        //         //     "auth"=>array(
        //         //         array("name"=>'查看区域','action'=>"admin/area/addArticle"),
        //         //         array("name"=>'添加','action'=>"admin/area/addArticle"),
        //         //         array("name"=>'删除','action'=>"admin/area/delArticle"),
        //         //         array("name"=>'修改','action'=>"admin/area/updateArticle"),
        //         //     )
        //         // )

        //     )
        // ),

		array(
			'name'=>'管理员管理',
	        'controller'=>'admin/User',
	        // 'icon'=>'fa-user',
			'child'=>array(

				array(
					'name'=>'管理员列表',

					'action'=>'admin/User/userList',

	                "auth"=>array(
	                	array("name"=>'添加','action'=>"admin/User/addUser"),
	                	array("name"=>'删除','action'=>"admin/User/delUser"),
	                	array("name"=>'修改','action'=>"admin/User/updateUser"),
	                )
				),
				array(
					'name'=>'用户列表',

					'action'=>'admin/Userregister/userList',

					"auth"=>array(
						array("name"=>'添加','action'=>"admin/Userregister/addUser"),
						array("name"=>'删除','action'=>"admin/Userregister/delUser"),
						array("name"=>'修改','action'=>"admin/Userregister/updateUser"),
					)
				)
	            
	            /*array(
					'name'=>'角色管理',

					'action'=>'admin/Role/roleList',

	                "auth"=>array(
	                    array("name"=>'添加','action'=>"admin/Role/addRoleAuth"),
	                	array("name"=>'删除','action'=>"admin/Role/delRole"),
	                	array("name"=>'修改','action'=>"admin/Role/updateRoleAuth"),
	                )
			    ),*/
			    
		    )
		    
		),

        // array(
		// 	'name'=>'系统管理',
	    //     'controller'=>'admin/System',
	    //     'icon'=>'fa-gear',
		// 	'child'=>array(

		// 		 array(
		// 		 	'name'=>'系统设置',

		// 		 	'action'=>'admin/System/systemSetup',

		// 	       "auth"=>array(
		// 	             array("name"=>'添加','action'=>"admin/System/add"),
		// 	             array("name"=>'删除','action'=>"admin/System/delete"),
		// 	             array("name"=>'编辑','action'=>"admin/System/edit"),
		// 	        )
		// 	     ),

	    //         array(
		// 			'name'=>'首页菜单',

		// 			'action'=>'admin/System/navMenu',

		// 	      "auth"=>array(
		// 	            array("name"=>'添加','action'=>"admin/System/addMenu"),
		// 	            array("name"=>'删除','action'=>"admin/System/delMenu"),
		// 	            array("name"=>'编辑','action'=>"admin/System/editMenu"),
		// 	       )
		// 	    ),

	    //         array(
		// 			'name'=>'系统日志',

		// 			'action'=>'admin/System/systemLog',

	    //             "auth"=>array(
	    //             	array("name"=>'添加','action'=>"admin/System/addLog"),
	    //             	array("name"=>'删除','action'=>"admin/System/delLog")
	    //             )
		// 	    ),

		// 	    array(
		// 			'name'=>'字体图标1',

		// 			'action'=>'admin/System/fontIcon',

	    //             "auth"=>array(
	    //             )
		// 	    ),

		// 	    array(
		// 			'name'=>'字体图标2',

		// 			'action'=>'admin/System/glyphIcon',

	    //             "auth"=>array(
	    //             )
		// 	    ),
		//     )
		   
		// ),

       
	    
		

		


		// array(
		// 	'name'=>'文章管理',
	    //     'controller'=>'admin/Order',
	    //     'icon'=>'fa-edit',
		// 	'child'=>array(

		// 		array(
		// 			'name'=>'文章列表',

		// 			'action'=>'admin/Article/articleList',

	    //             "auth"=>array(
	    //             	array("name"=>'添加','action'=>"admin/Article/addArticle"),
	    //             	array("name"=>'删除','action'=>"admin/Article/delArticle"),
	    //             	array("name"=>'修改','action'=>"admin/Article/updateArticle"),
	    //             )
		// 	    ),
	            
		//     )
		    
		// )

	),
	
);