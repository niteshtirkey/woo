jQuery(document).ready(function($) {
    var $height = $('#csp-height');
    var $width = $('#csp-width');
    var $priceDisplay = $('#csp-calculated-price');
    var $priceValue = $('#csp-price-value');
    var $error = $('#csp-error');
    var $addToCart = $('.single_add_to_cart_button');
    var ranges = JSON.parse($('#csp-ranges').val() || '[]');
    
    // Disable add to cart initially
    $addToCart.prop('disabled', true);
    
    function calculatePrice() {
        var height = parseFloat($height.val());
        var width = parseFloat($width.val());
        
        if (!height || !width) {
            $priceDisplay.hide();
            $error.hide();
            $addToCart.prop('disabled', true);
            return;
        }
        
        var matched = false;
        
        for (var i = 0; i < ranges.length; i++) {
            var range = ranges[i];
            if (height >= range.height_min && height <= range.height_max &&
                width >= range.width_min && width <= range.width_max) {
                
                $priceValue.text('$' + parseFloat(range.price).toFixed(2));
                $priceDisplay.show();
                $error.hide();
                $addToCart.prop('disabled', false);
                matched = true;
                break;
            }
        }
        
        if (!matched) {
            $priceDisplay.hide();
            $error.text('Invalid dimensions. No matching size range found.').show();
            $addToCart.prop('disabled', true);
        }
    }
    
    $height.on('input change', calculatePrice);
    $width.on('input change', calculatePrice);
});
