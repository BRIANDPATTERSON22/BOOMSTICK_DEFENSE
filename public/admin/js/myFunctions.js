$(document).ready(function(){
    var c_m_i = $('.pro-cat-name').val();
    $('select[name="category_main_id"]').val(c_m_i).change();
});

function select_category_menu(href){
    var pro_cat_id = $('.pro-cat-name').val();
    var idx = href+'/admin/products-category-menu';
    var data="pro_cat_id="+pro_cat_id;
    var c_m_i =  $('.pro-cat-sub-name').val();
    $.ajax({
        type:'GET',url:idx,data:data,
        success:function(data){
            $('.pro-cat-sub-name').html(data);
            $('.pro-cat-sub-name').val(c_m_i).attr('selected', 'selected').change();
            //$('.pro-cat-sub-name').trigger('change');
        }
    })
}

function select_sub_category_type_menu(href){
    var pro_sub_cat_type_id = $('.pro-sub-cat-type-name').val();
    // console.log(pro_sub_cat_type_id);
    var idx = href+'/admin/products-sub-category-type-menu';
    var data="pro_sub_cat_type_id="+pro_sub_cat_type_id;
    // console.log(data);
    var c_i =  $('.pro-cat-type-name').val();
    $.ajax({
        type:'GET',url:idx,data:data,
        success:function(data){
            $('.pro-cat-type-name').html(data);
            //$('.pro-cat-type-name').trigger('change');
            $('.pro-cat-type-name').val(c_i).attr('selected', 'selected').change();
        }
    })
}

function select_division(href){
    // Get Store Category/ Division Id
    var store_cat_id = $('#store_category_id').val();

    // Data URL
    var dataURL = href+'/admin/stores-category-menu';

    // Query String
    var data="store_cat_id="+store_cat_id; //store_cat_id=14

    //Get Store table id
    var storesData =  $('#stores').val();

    $.ajax({
        type:'GET',
        url:dataURL,
        data:data,
        success:function(data){
            $('#stores').html(data);
            $('#stores').val(storesData).attr('selected', 'selected').change();
            //$('.pro-cat-sub-name').trigger('change');
        }
    })
}