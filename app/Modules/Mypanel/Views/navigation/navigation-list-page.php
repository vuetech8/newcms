
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
            <?php if(isset($current_menu['menu']) && !empty($current_menu['menu'])){?>
                <a data-toggle="modal" data-target="#sorting-model" class="btn btn-sm btn-default pull-right">Sorting</a>
                <a href="<?php echo site_url($current_menu['menu']->ipy_slug.'/add');?>" class="btn btn-sm btn-secondary pull-right">Add new</a>
            <?php }?>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>For</th>
                        <th>Cr Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>View</th>
                        <th>For</th>
                        <th>Cr Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if(isset($navigation) && !empty($navigation)){$i=1;?>
                        <?php foreach($navigation as $nav){?>
                            <?php 
                                $navLink='';
                                if($nav->ipy_type=='self'){$navLink='<a href="'.site_url('p/'.$nav->ipy_slug).'" class="btn btn-sm btn-secondary" target="_blank">View</a>';}
                                if($nav->ipy_type=='direct_link'){$navLink='<a href="'.$nav->ipy_link.'" class="btn btn-sm btn-secondary" target="_blank">View</a>';}
                                if($nav->ipy_type=='file'){$navLink='<a href="'.base_url($nav->ipy_file).'" class="btn btn-sm btn-secondary" target="_blank">View</a>';}
                                if($nav->ipy_type=='template'){$navLink='<a class="btn btn-sm btn-secondary">Template</a>';}
                            ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo $nav->ipy_name;?></td>
                                <td><?php echo $nav->parent_name ?? '-';?></td>
                                <td><?php echo ucfirst($nav->ipy_status);?></td>
                                <td><?php echo $navLink;?></td>
                                <td><?php echo ucfirst($nav->ipy_for);?></td>
                                <td><?php echo date('d-m-Y',strtotime($nav->ipy_crdate));?></td>
                                <td>
                                    <div class="btn-group">
                                        <?php if(isset($current_menu['menu']) && !empty($current_menu['menu'])){?>
                                            <a href="<?php echo site_url($current_menu['menu']->ipy_slug.'/edit/'.$nav->ipy_id);?>" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo site_url($current_menu['menu']->ipy_slug.'/delete/'.$nav->ipy_id);?>" onclick="return confirm('Do you want to Delete Item')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        <?php }?>
                                    </div>
                                </td>
                            </tr>
                        <?php }?>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="sorting-model">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sorting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <?php echo form_open(site_url('mypanel/action/navigationsort'));?>
                <div class="modal-body">
                    <h4>Top Navigation</h4>
                    <?php getSortingNav(0,1,'navigation','ipy_name','top-navigation');?>
                    <h4>Footer Link 1</h4>
                    <?php getSortingNav(0,1,'navigation','ipy_name','footer-link-1');?>
                    <h4>Footer Link 2</h4>
                    <?php getSortingNav(0,1,'navigation','ipy_name','footer-link-2');?>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-secondary">Update</button>
                    <input type="hidden" name="backURL" value="<?php echo site_url('mypanel/navigation');?>" />
                    <input type="hidden" name="updateto" value="navigation" />
                </div>
            <?php echo form_close();?>
        </div>
        <!-- /.modal-content -->
    </div>
</div>