<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, http://ifsoft.co.uk
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2019 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $banner = new banner($dbo);

    $bannerId = 0;
    $bannerInfo = array();

    if (isset($_GET['id'])) {

		$bannerId = isset($_GET['id']) ? $_GET['id'] : 0;

		$bannerId = helper::clearInt($bannerId);

		if ($bannerId == 0) {

            header("Location: /".APP_ADMIN_PANEL."/banner");
            exit;
		}

		$bannerInfo = $banner->info($bannerId);
	//	var_dump($bannerInfo);die;

	} else {

	    header("Location: /".APP_ADMIN_PANEL."/banner");
        exit;
	}

    if (!empty($_POST)) {

        $authToken = isset($_POST['authenticity_token']) ? $_POST['authenticity_token'] : '';
		$status = isset($_POST['status']) ? $_POST['status'] : "";
		$image=	$_FILES["image"]["name"];
	//	var_dump($image); die;
        $target_dir = "uploads/";
       $target_file = $target_dir . basename($_FILES["image"]["name"]);
       move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		$status = helper::clearText($status);
		$status = helper::escapeText($status);

		if ($authToken === helper::getAuthenticityToken() && !APP_DEMO && strlen($status) != 0) {

		    $banner->edit($bannerId, $status,$image);

	

		        header("Location: /".APP_ADMIN_PANEL."/banner");
                exit;

		  //  } else {

    //             header("Location: /".APP_ADMIN_PANEL."/subcategory?id=".$categoryInfo['mainCategoryId']);
    //             exit;
		  //  }
		}
	}

    $page_id = "banner_edit";

    helper::newAuthenticityToken();

    $css_files = array("mytheme.css");
    $page_title = "Banner"." | Admin Panel";

    include_once("common/admin_header.inc.php");
?>

<body class="fix-header fix-sidebar card-no-border">

    <div id="main-wrapper">

        <?php

            include_once("common/admin_topbar.inc.php");
        ?>

        <?php

            include_once("common/admin_sidebar.inc.php");
        ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor"><?php echo $LANG['apanel-dashboard']; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/<?php echo APP_ADMIN_PANEL; ?>/dashboard"><?php echo $LANG['apanel-home']; ?></a></li>
                            <li class="breadcrumb-item active">Banner update</li>
                        </ol>
                    </div>
                </div>

                <?php

                    include_once("common/admin_banner.inc.php");
                ?>

                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Banner</h4>

                                    <div class="row">

                                        <div class="col-sm-12 col-xs-12">

                                            <form id="new-category-form" class="input-form-2" method="post" enctype="multipart/form-data" action="/<?php echo APP_ADMIN_PANEL; ?>/banner_edit?id=<?php echo $bannerInfo['id']; ?>">

                                                <input type="hidden" name="authenticity_token" value="<?php echo helper::getAuthenticityToken(); ?>">

												<div class="row">
												    
												    	<div class="col-lg-12">
													<div class="input-group">
													    
													    <select class="form-control" name="status" required>
													        <option value="1">Active</option>
													        <option value="0">Inactive</option>
													        
													    </select>
													    </div>
													</div>	

													<div class="col-lg-12">
														<div class="input-group">
															<input type="file" class="form-control" id="catimg" name="image"  placeholder="">
														</div>
													</div>
														<?php
													if($bannerInfo['image']){
													    ?>
													<br>	<br>
													
													<img src="../uploads/<?php echo $bannerInfo['image']; ?>"  width="150" height="150">
													<?php
													}
													?>
													
													

													<div class="col-lg-12">
														<div class="form-group mb-0 mt-2 text-right">
															<button type="submit" class="btn btn-info" type="button"><?php echo $LANG['apanel-action-create']; ?></button>
														</div>
													</div>

												</div>

													<!-- form-group -->
											</form>
										</div>

									</div>

                                </div>
                            </div>
                        </div>

                    </div>


            </div> <!-- End Container fluid  -->

            <?php

                include_once("common/admin_footer.inc.php");
            ?>

        </div> <!-- End Page wrapper  -->
    </div> <!-- End Wrapper -->

</body>

</html>
