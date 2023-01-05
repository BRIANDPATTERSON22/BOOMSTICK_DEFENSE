
function select_category_menu(href){
    var pro_cat_id = $('.pro-cat-name').val();
    // console.log(pro_cat_id);
    var idx = href+'/admin/products-category-menu';
    var idtype = href+'/admin/products-category-type-menu';
    // console.log(idtype);

    var data="pro_cat_id="+pro_cat_id;
    // console.log(data);

    $.ajax({
        type:'GET',url:idx,data:data,
        success:function(data){
            $('.pro-cat-sub-name').html(data);
            $('.pro-cat-sub-name').trigger('change');
        }
    })

    $.ajax({
        type:'GET',url:idtype,data:data,
        success:function(data){
            $('.pro-cat-type-name').html(data);
            $('.pro-cat-type-name').trigger('change');
        }
    })


}