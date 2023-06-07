<?php $editData=(isset($edit->ipy_data) && $edit->ipy_data!='' ? json_decode($edit->ipy_data,true) : '');?>
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
            <?php echo form_open(site_url('mypanel/action/navigation/update'),array('class'=>'ajax-form','data-form-validate'=>'true','novalidate'=>'novalidate'));?>
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
                                            <input type="text" name="data_name" class="form-control required" value="<?php echo (isset($edit->ipy_name) && $edit->ipy_name!='' ? $edit->ipy_name : '');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="self" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='self' ? 'checked="checked"' : '');?>>&nbsp; Self</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="direct_link" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='direct_link' ? 'checked="checked"' : '');?>>&nbsp; Direct Link</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="file" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='file' ? 'checked="checked"' : '');?>>&nbsp; File</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="childs" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='childs' ? 'checked="checked"' : '');?>>&nbsp; Display Child(s) Menu</label>
                                    <label class="checkbox-inline"><input type="radio" class="page_attribute" name="data_type" value="template" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='template' ? 'checked="checked"' : '');?>>&nbsp; Template</label>
                                </div>

                                <!--Self Form action start-->
                                    <div class="page_attribute_value self" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='self' ? 'style="display:block"' : 'style="display:none"');?>>
                                        <div class="panel panel-primary">
                                            <label>Select Page</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <select class="form-control width50 required" name="data_pageid">
                                                        <option value="">----select page----</option>
                                                        <?php if(isset($pages) && !empty($pages)){?>
                                                            <?php foreach($pages as $p){?>
                                                                <option value="<?php echo $p->ipy_id;?>" <?php echo (isset($edit->ipy_value) && $edit->ipy_value==$p->ipy_id ? 'selected="selected"' : '');?>><?php echo $p->ipy_name;?></option>
                                                            <?php }?>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--Self Form action END-->

                                <!--Direct Link page action start-->
                                    <div class="page_attribute_value direct_link" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='direct_link' ? 'style="display:block"' : 'style="display:none"');?>>
                                        <div class="panel panel-primary">
                                            <label>Enter the url</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <input class="form-control required" type="text" name="data_link" placeholder="Enter the url" value="<?php echo (isset($edit->ipy_link) && $edit->ipy_link!='' ? $edit->ipy_link : '');?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--Direct Link page action end-->

                                <!--File Upload action start-->
                                    <div class="page_attribute_value file" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='file' ? 'style="display:block"' : 'style="display:none"');?>>
                                        <div class="panel panel-primary">
                                            <label>Select File</label>
                                            <div class="panel-content">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mainatl">
                                                            <input type="file" name="nav_file_uploader" class="form-control autoupload" value="">
                                                            <input type="hidden" name="data_file" id="nav_file_uploader"class="form-control" value="<?php echo (isset($edit->ipy_file) && $edit->ipy_file!='' ? $edit->ipy_file : '');?>">
                                                            <div class="filemsg"><?php echo (isset($edit->ipy_file) && $edit->ipy_file!='' ? '<a href="'.base_url($edit->ipy_file).'" class="btn btn-sm btn-dark m-1" target="_blank">View</a> <button class="delete-file">X</button>' : '');?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--File Upload action end-->

                                <!--template action start-->
                                    <div class="page_attribute_value template" <?php echo (isset($edit->ipy_type) && $edit->ipy_type=='template' ? 'style="display:block"' : 'style="display:none"');?>>
                                        <div class="panel panel-primary">
                                            <label>Select Template</label>
                                            <div class="panel-content">
                                                <div class="form-group">
                                                    <select class="form-control width50 required" name="data_template">
                                                        <option value="">----select Template----</option>
                                                        <option value="template-1" <?php echo (isset($edit->ipy_template) && $edit->ipy_template=='template-1' ? 'selected="selected"' : '');?>>Template 1</option>
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
                                            <input type="text" name="data_header_title" class="form-control" value="<?php echo (isset($editData['data_header_title']) && $editData['data_header_title']!='' ? $editData['data_header_title'] : '');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 form-group mainatl">
                                        <label>Banner Image:</label>
                                        <input type="file" name="banner_img_uploader" class="form-control autoupload" value="">
                                        <input type="hidden" name="data_banner" id="banner_img_uploader" class="form-control" value="<?php echo (isset($editData['data_banner']) && $editData['data_banner']!='' ? $editData['data_banner'] : '');?>">
                                        <div class="filemsg"><?php echo (isset($editData['data_banner']) && $editData['data_banner']!='' ? '<a href="'.base_url($editData['data_banner']).'" class="btn btn-sm btn-dark m-1" target="_blank">View</a> <button class="delete-file">X</button>' : '');?></div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mainatl">
                                            <label>Banner Background Image:</label>
                                            <input type="file" name="banner_bg_img_uploader" class="form-control autoupload" value="">
                                            <input type="hidden" name="data_banner_bg_img" id="banner_bg_img_uploader"class="form-control" value="<?php echo (isset($editData['data_banner_bg_img']) && $editData['data_banner_bg_img']!='' ? $editData['data_banner_bg_img'] : '');?>">
                                            <div class="filemsg"><?php echo (isset($editData['data_banner_bg_img']) && $editData['data_banner_bg_img']!='' ? '<a href="'.base_url($editData['data_banner_bg_img']).'" class="btn btn-sm btn-dark m-1" target="_blank">View</a> <button class="delete-file">X</button>' : '');?></div>
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
                                            <input type="text" name="seo_title" class="form-control" value="<?php echo (isset($editData['seo_title']) && $editData['seo_title']!='' ? $editData['seo_title'] : '');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>SEO Description:</label>
                                            <input type="text" name="seo_description" class="form-control" value="<?php echo (isset($editData['seo_description']) && $editData['seo_description']!='' ? $editData['seo_description'] : '');?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mainatl">
                                        <div class="form-group">
                                            <label>SEO Image:</label>
                                            <input type="file" name="seo_image_uploader" class="form-control autoupload" value="">
                                            <input type="hidden" name="seo_image" id="seo_image_uploader"class="form-control" value="<?php echo (isset($editData['seo_image']) && $editData['seo_image']!='' ? $editData['seo_image'] : '');?>">
                                            <div class="filemsg"><?php echo (isset($editData['seo_image']) && $editData['seo_image']!='' ? '<a href="'.base_url($editData['seo_image']).'" class="btn btn-sm btn-dark m-1" target="_blank">View</a> <button class="delete-file">X</button>' : '');?></div>
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
                                <input type="hidden" name="editid" value="<?php echo (isset($edit->ipy_id) && $edit->ipy_id!='' ? $edit->ipy_id : '');?>"/>
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
                                            <?php if(isset($edit->ipy_id) && $edit->ipy_id!=$p->ipy_id){?>
                                                <option value="<?php echo $p->ipy_id;?>" <?php echo (isset($edit->ipy_parent) && $edit->ipy_parent==$p->ipy_id ? 'selected="selected"' : '');?>><?php echo $p->ipy_name;?></option>
                                            <?php }?>
                                        <?php }?>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Slug</div>
                            <div class="card-body">
                                <input type="text" name="newslug" class="form-control" value="<?php echo (isset($edit->ipy_slug) && $edit->ipy_slug!='' ? $edit->ipy_slug : '');?>">
                                <input type="hidden" name="oldslug" class="form-control" value="<?php echo (isset($edit->ipy_slug) && $edit->ipy_slug!='' ? $edit->ipy_slug : '');?>">
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Status</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_status">
                                    <option value="active" <?php echo (isset($edit->ipy_status) && $edit->ipy_status=='active' ? 'selected="selected"' : '');?>>Active</option>
                                    <option value="draft" <?php echo (isset($edit->ipy_status) && $edit->ipy_status=='draft' ? 'selected="selected"' : '');?>>Draft</option>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">Visibility</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_visible">
                                    <option value="yes" <?php echo (isset($edit->ipy_visible) && $edit->ipy_visible=='yes' ? 'selected="selected"' : '');?>>Yes</option>
                                    <option value="no" <?php echo (isset($edit->ipy_visible) && $edit->ipy_visible=='no' ? 'selected="selected"' : '');?>>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-header">For</div>
                            <div class="card-body">
                                <select class="form-control required" name="data_for">
                                    <option value="top-navigation" <?php echo (isset($edit->ipy_for) && $edit->ipy_for=='top-navigation' ? 'selected="selected"' : '');?>>Top Navigation</option>
                                    <option value="footer-link-1" <?php echo (isset($edit->ipy_for) && $edit->ipy_for=='footer-link-1' ? 'selected="selected"' : '');?>>Footer Link 1</option>
                                    <option value="footer-link-2" <?php echo (isset($edit->ipy_for) && $edit->ipy_for=='footer-link-2' ? 'selected="selected"' : '');?>>Footer Link 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>