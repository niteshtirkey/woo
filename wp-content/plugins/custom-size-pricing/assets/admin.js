jQuery(document).ready(function($) {
    // Add new range row
    $('#csp-add-range').on('click', function() {
        var row = `
            <div class="csp-range-row">
                <label>Height Min: <input type="number" step="0.01" name="csp_height_min[]" required /></label>
                <label>Height Max: <input type="number" step="0.01" name="csp_height_max[]" required /></label>
                <label>Width Min: <input type="number" step="0.01" name="csp_width_min[]" required /></label>
                <label>Width Max: <input type="number" step="0.01" name="csp_width_max[]" required /></label>
                <label>Price: <input type="number" step="0.01" name="csp_price[]" required /></label>
                <button type="button" class="button csp-remove-range">Remove</button>
            </div>
        `;
        $('#csp-ranges-container').append(row);
    });
    
    // Remove range row
    $(document).on('click', '.csp-remove-range', function() {
        $(this).closest('.csp-range-row').remove();
    });
});
