$(document).ready(function() {

    /* Magic Validation */
    /*-----------------------------------------------------*/
    clearError = function(element)
    {
        $(element + ' .form-group').removeClass('has-error');
        $(element + ' .error-message').remove();
    }

    populateError = function(element, data)
    {
        // loop error message
        var focus = "";
        var i=0;
        $.each(data, function(key, value) {
            // get parent form-group and add class error
            var elm = $(element + ' [name=' + key + ']').closest('.form-group');
            $(elm).addClass('has-error');

            // add message to form-group
            var showerror = $(element + ' [name=' + key + ']').parent();
            $(showerror).append('<span class="error-message help-block">' + value + '</span>');

            // get first focus error
            if (i==0) {
                focus = element + ' [name=' + key + ']';
            }
            i++;
        });

        // focus element
        $(focus).focus();

        //$.scrollTo('#form-data input[name=name]', 0, {offset: -$(window).height() /2});
    }

});
