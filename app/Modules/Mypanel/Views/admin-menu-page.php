<div class="container-fluid px-4">
    <h1 class="mt-4">Admin Menu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Admin Menu</li>
    </ol>

    <div class="right-content-sec">
        <div class="row">
            <div class="col-5">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        Add New Menu
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if(session()->getFlashdata('getSuccess')):?>
                                    <?= session()->getFlashdata('getSuccess') ?>
                                <?php endif;?>
                            </div>
                        </div>
                        <?php if(isset($action) && $action=='edit' && has_permission('edit')==1){?>
                            <?php echo form_open(site_url('mypanel/action/nav/update'),array('class'=>'ajax-form','data-form-validate'=>'true','novalidate'=>'novalidate'));?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Parent: </label>
                                            <select name="parent" class="form-control"
                                                value="<?php echo set_value('parent]');?>">
                                                <option value="">Select parent</option>
                                                <?php if(isset($parent) && !empty($parent)){?>
                                                    <?php foreach($parent as $p){?>
                                                        <option value="<?php echo $p->ipy_id;?>" <?php echo (isset($edit) && $edit->ipy_parent==$p->ipy_id ? 'selected="selected"' : '');?>><?php echo $p->ipy_name;?></option>
                                                    <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Name: <span>*</span></label>
                                            <input type="text" name="name" class="form-control required"
                                                value="<?php echo (isset($edit) && $edit->ipy_name!='' ? $edit->ipy_name : '');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Link: <span>*</span></label>
                                            <input type="text" name="slug" class="form-control required"
                                                value="<?php echo (isset($edit) && $edit->ipy_slug!='' ? $edit->ipy_slug : '');?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <select class="form-control required" name="status">
                                                    <option value="1" <?php echo (isset($edit) && $edit->ipy_status=='1' ? 'selected="selected"' : '');?>>Active</option>
                                                    <option value="0" <?php echo (isset($edit) && $edit->ipy_status=='0' ? 'selected="selected"' : '');?>>Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <input type="text" name="sorting" class="form-control required"
                                                    value="<?php echo (isset($edit) && $edit->ipy_sorting!='' ? $edit->ipy_sorting : '0');?>"
                                                    placeholder="Sorting">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <input type="hidden" name="editid" class="form-control"
                                                    value="<?php echo (isset($edit) && $edit->ipy_id!='' ? $edit->ipy_id : '');?>">
                                                <button type="submit" name="publish"
                                                    class="btn btn-md btn-block btn-primary ajax-submit-btn">PUBLISH</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="ajax-message"></div>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        <?php }else{?>
                            <?php echo form_open(site_url('mypanel/action/nav/add'),array('class'=>'ajax-form','data-form-validate'=>'true','novalidate'=>'novalidate'));?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Parent: </label>
                                            <select name="parent" class="form-control">
                                                <option value="">Select parent</option>
                                                <?php if(isset($parent) && !empty($parent)){?>
                                                    <?php foreach($parent as $p){?>
                                                        <option value="<?php echo $p->ipy_id;?>"><?php echo $p->ipy_name;?></option>
                                                    <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Name: <span>*</span></label>
                                            <input type="text" name="name" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Link: <span>*</span></label>
                                            <input type="text" name="slug" class="form-control required" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <select class="form-control required" name="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Draft</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <input type="text" name="sorting" class="form-control required" value="0"
                                                    placeholder="Sorting">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <button type="submit" name="publish" class="btn btn-md btn-block btn-primary ajax-submit-btn">PUBLISH</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="ajax-message"></div>
                                    </div>
                                </div>
                            <?php echo form_close();?>
                        <?php }?>
                    </div>
                    <div class="card-footer small text-muted"></div>
                </div>
            </div>
            <div class="col-7">
                <div class="menus-list">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-edit me-1"></i>
                            Admin Menu List
                        </div>
                        <div class="card-body">
                            <?php echo getAdminMenuListPage(0);?>
                        </div>
                        <div class="card-footer small text-muted"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>