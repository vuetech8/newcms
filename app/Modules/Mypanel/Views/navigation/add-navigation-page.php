<?php 
    //$parent=$this->mypanel_model->getData(array('table'=>'navigation','status'=>'active','orderby'=>'ipy_id','order'=>'DESC'))->result();
    //$pages=$this->mypanel_model->getData(array('table'=>'pages','status'=>'active','orderby'=>'ipy_id','order'=>'DESC'))->result(); 
?>

<div class="container-fluid px-4">
    <?php $breadcum=(null!==(adminBreadcum()) && adminBreadcum()!='' ? explode(',',adminBreadcum()) : '');?>
    <?php if(isset($breadcum) && !empty($breadcum)){?>
        <h1 class="mt-4"><?php echo $breadcum[0] ?? '';?></h1>
        <ol class="breadcrumb mb-4">
            <?php for($i=count($breadcum)-1;$i>=0;$i--){?>
                <?php if($i==0){?>
                    <li class="breadcrumb-item active"><?php echo $breadcum[$i];?></li>
                <?php }else{?>
                    <li class="breadcrumb-item"><a href="#"><?php echo $breadcum[$i];?></a></li>
                <?php }?>
            <?php }?>
        </ol>
    <?php }?>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            <?php echo (isset($breadcum[0]) && $breadcum[0]!='' ? $breadcum[0] : '');?>
        </div>
        <div class="card-body">
            <?php echo form_open(site_url('mypanel/action/navigation/add'),array('class'=>'ajax-form','data-form-validate'=>'true','novalidate'=>'novalidate'));?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ajax-message"></div>
                    </div>
                    <div class="col-9">
                        <!-- Default box -->
                        <div class="card mb-3">
                            <div class="card-header">
                                Fill the required fields
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php if(session()->getFlashdata('getSuccess')):?>
                                            <?= session()->getFlashdata('getSuccess') ?>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Name: <span>*</span></label>
                                            <input type="text" name="data_name" class="form-control required" value="<?php echo set_value('name');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="self" checked="checked">&nbsp; Self</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="direct_link">&nbsp; Direct Link</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="file">&nbsp; File</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="childs">&nbsp; Display Child(s) Menu</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="template">&nbsp; Template</label>
                                </div>

                                <!--Self Form action start-->
                                    <div class="page_attribute_value self" style="display:block">
                                        <div class="panel panel-primary">
                                            <label>Select Page</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <select class="form-control width50 required" name="data_pageid">
                                                        <option value="">----select page----</option>
                                                        <?php if(isset($pages) && !empty($pages)){?>
                                                            <?php foreach($pages as $p){?>
                                                                <option value="<?php echo $p->ipy_id;?>"><?php echo $p->ipy_name;?></option>
                                                            <?php }?>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--Self Form action END-->

                                <!--Direct Link page action start-->
                                    <div class="page_attribute_value direct_link">
                                        <div class="panel panel-primary">
                                            <label>Enter the url</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <input class="form-control required" type="text" name="data_link" placeholder="Enter the url" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--Direct Link page action end-->

                                <!--File Upload action start-->
                                    <div class="page_attribute_value file">
                                        <div class="panel panel-primary">
                                            <label>Select File</label>
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mainatl">
                                                            <input type="file" name="nav_file_uploader" class="form-control autoupload" value="">
                                                            <input type="hidden" name="data_file" id="nav_file_uploader"class="form-control" value="">
                                                            <div class="filemsg"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--File Upload action end-->

                                <!--template action start-->
                                    <div class="page_attribute_value template">
                                        <div class="panel panel-primary">
                                            <label>Select Template</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <select class="form-control width50 required" name="data_template">
                                                        <option value="">----select Template----</option>
                                                        <option value="template-1">Template 1</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--template action END-->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card collapsed-card mb-3">
                            <div class="card-header">Setting</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Header Title (If any):</label>
                                            <input type="text" name="data_header_title" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group mainatl">
                                        <label>Banner Image:</label>
                                        <input type="file" name="banner_img_uploader" class="form-control autoupload" value="">
                                        <input type="hidden" name="data_banner" id="banner_img_uploader" class="form-control" value="">
                                        <div class="filemsg"></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mainatl">
                                            <label>Banner Background Image:</label>
                                            <input type="file" name="banner_bg_img_uploader" class="form-control autoupload" value="">
                                            <input type="hidden" name="data_banner_bg_img" id="banner_bg_img_uploader"class="form-control" value="">
                                            <div class="filemsg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card collapsed-card mb-3">
                            <div class="card-header">SEO</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>SEO Title:</label>
                                            <input type="text" name="seo_title" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>SEO Description:</label>
                                            <input type="text" name="seo_description" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mainatl">
                                        <div class="form-group">
                                            <label>SEO Image:</label>
                                            <input type="file" name="seo_image_uploader" class="form-control autoupload" value="">
                                            <input type="hidden" name="seo_image" id="seo_image_uploader"class="form-control" value="">
                                            <div class="filemsg"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-3">
                        <div class="card card-primary card-outline mb-3">
                            <div class="card-body">
                                <button type="submit" name="publish" class="btn btn-md btn-block btn-primary ajax-submit-btn">PUBLISH</button>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Parent</div>
                            <div class="card-body">
                                <select name="data_parent" class="form-control">
                                    <option value="0">Select parent</option>
                                    <?php if(isset($parent) && !empty($parent)){?>
                                        <?php foreach($parent as $p){?>
                                            <option value="<?php echo $p->ipy_id;?>"><?php echo $p->ipy_name;?></option>
                                        <?php }?>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Status</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_status">
                                    <option value="active">Active</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Visibility</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_visible">
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">For</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_for">
                                    <option value="top-navigation">Top Navigation</option>
                                    <option value="footer-link-1">Footer Link 1</option>
                                    <option value="footer-link-2">Footer Link 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>