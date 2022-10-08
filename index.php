<?php include "./pages/header_area.php"?>
<div id="flter" class="shop_sidebar_area">
    <div class="widget brands mb-50">
        <h6 class="widget-title mb-30">Danh mục</h6>
        <div class="widget-desc">
        <?php
        $result = mysqli_query($conn,"SELECT `id`, `name` FROM `categories`");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
        ?>
        <div class="form-check">
            <input class="common_selector category form-check-input" type="checkbox" value="<?php echo$row['id'];?>" id="<?php echo $row['name'] ?>">
            <label class="form-check-label" for="<?php echo $row['name'] ?>"><?php echo $row['name'] ?></label>
        </div>
        <?php } } ?>
    </div>
</div>
<div class="widget price mb-50">
    <h6 class="widget-title mb-30">Giá</h6>
    <div class="widget-desc">
        <div class="slider-range">
            <div data-min="1000000" data-max="50000000" data-unit="" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="1000000" data-value-max="50000000" data-label-result="">
                <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
            </div>
            <div class="range-price">1.000.000 ₫ - 50.000.000 ₫</div>
            <input type="hidden" min="1000000" max="50000000" oninput="validity.valid||(value='0');" id="min_price" class="price-range-field" /><input type="hidden" min="1000000" max="50000000" oninput="validity.valid||(value='50000000');" id="max_price" class="price-range-field" />
        </div>
    </div>
</div>
</div>
<div class="amado_product_area section-padding-100">
    <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                <div class="total-products">
                    <div class="view d-flex">
                        <a href="#flter"><i class="fa fa-bars" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="filter_data"></div> 
    </div>
</div>
<?php include "./pages/footer.php";?>
<script>
    $( document ).ready(function() {
        filter_data();
        function filter_data(page)
        {
            var action = 'fetch_data';
            var minimum_price = $('#min_price').val();
            var maximum_price = $('#max_price').val();
            var category = get_filter('category');
            var search = $("#search").val();
            $.ajax({
                url:"fetch_data.php",
                method:"POST",
                data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, category:category, page:page, search:search},
                success:function(data){
                    $('.filter_data').html(data);
                }
            });
        }
        function get_filter(class_name)
        {
            var filter = [];
            $('.'+class_name+':checked').each(function(){
                filter.push($(this).val());
            });
            return filter;
        }
        $('.common_selector').click(function(){
            filter_data();
        });

        $('.slider-range-price').each(function () {
            var min = jQuery(this).data('min');
            var max = jQuery(this).data('max');
            var unit = jQuery(this).data('unit');
            var value_min = jQuery(this).data('value-min');
            var value_max = jQuery(this).data('value-max');
            var label_result = jQuery(this).data('label-result');
            var t = $(this);
            $(this).slider({
                range: true,
                min: min,
                max: max,
                values: [value_min, value_max],
                slide: function (event, ui) {
                    var result = label_result + " " + unit + ui.values[0].toLocaleString('vi', {style : 'currency', currency : 'VND'}) + ' - ' + unit + ui.values[1].toLocaleString('vi', {style : 'currency', currency : 'VND'});
                    console.log(t);
                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                    t.closest('.slider-range').find('.range-price').html(result);
                    filter_data();
                }
            });
        });
        $(document).on('click', '.page-link', function(){  
            var page = $(this).attr("id");  
            filter_data(page);  
        });
        $( "#search_form" ).submit(function( e ) {
        e.preventDefault();
        filter_data();
        $('.header-area').removeClass('bp-xs-on');
        $('body').removeClass('search-wrapper-on');
    }); 
    });
</script>
