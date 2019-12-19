function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#photo1')
                .attr('src', e.target.result)
                .width(150)
                .height(200);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(function () {
    $('[data-toggle="popover"]').popover();
});

$('#productEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var formaction = button.data('formaction');
    var title = button.data('title');
    var author = button.data('author');
    var originalprice = button.data('originalprice');
    var sellingprice = button.data('sellingprice');
    var stock = button.data('stock');
    var productid = button.data('productid');
     // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);

    modal.find('.modal-title').html('Edit Your Product');
    modal.find('#productEditForm').attr("action",formaction );
    modal.find('#inputProductid').val(productid);
    modal.find('#inputTitle').val(title);
    modal.find('#inputAuthor ' ).val(author);
    modal.find('#inputPrice ' ).val(originalprice);
    modal.find('#inputSellingPrice ' ).val(sellingprice);
    modal.find('#inputStock ' ).val(stock);

  });
  $('#linkedProductEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var title = button.data('title');
    var author = button.data('author');
    var originalprice = button.data('originalprice');
    var sellingprice = button.data('sellingprice');
    var stock = button.data('stock');
    var productid = button.data('productid');
     // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);

    modal.find('.modal-title').html('Edit Your Product');
    modal.find('#inputProductid').val(productid);
    modal.find('#inputTitle').val(title);
    modal.find('#inputAuthor ' ).val(author);
    modal.find('#inputPrice ' ).val(originalprice);
    modal.find('#inputSellingPrice ' ).val(sellingprice);
    modal.find('#inputStock ' ).val(stock);

  });

$(".fa-search").click(function () {
    $(".search-box").toggle();
    $("input[type='text']").focus();
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ajaxStart(function () {
    $("#loading-image").css("display", "block");
});
$(document).ajaxComplete(function () {
    $("#loading-image").css("display", "none");
});

