<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Order Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Validation plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Product Order Form</h2>
        <form id="orderForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullName" name="fullName" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="col-md-6">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <h3 class="mt-4 mb-3">Product Details</h3>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
                <div class="col-md-6">
                    <label for="company" class="form-label">Company</label>
                    <input type="text" class="form-control" id="company" name="company" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="color" class="form-label">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>
                <div class="col-md-4">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" class="form-control" id="size" name="size" required>
                </div>
                <div class="col-md-4">
                    <label for="variant" class="form-label">Variant</label>
                    <input type="text" class="form-control" id="variant" name="variant" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit Order</button>
        </form>
        <div id="response" class="mt-3"></div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        $.validator.addMethod("fullName", function(value, element) {
            return value.trim().indexOf(' ') !== -1;
        }, "Please enter your full name (first and last name)");

        $.validator.addMethod("phoneLength", function(value, element) {
            return value.replace(/\D/g, '').length === 10;
        }, "Phone number must be 10 digits long");

        $("#orderForm").validate({
            rules: {
                fullName: {
                    required: true,
                    fullName: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    phoneLength: true
                },
                address: "required",
                productName: "required",
                company: "required",
                color: "required",
                size: "required",
                variant: "required"
            },
            messages: {
                fullName: {
                    required: "Please enter your full name",
                    fullName: "Please enter your full name (first and last name)"
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address"
                },
                phone: {
                    required: "Please enter your phone number",
                    phoneLength: "Phone number must be 10 digits long"
                },
                address: "Please enter your address",
                productName: "Please enter the product name",
                company: "Please enter the company name",
                color: "Please enter the color",
                size: "Please enter the size",
                variant: "Please enter the variant"
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-control').after(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                $.ajax({
                    url: 'Ajax_requied.php',
                    type: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if(response.status === 'success') {
                            $('#response').html('<div class="alert alert-success">Order submitted successfully! Order ID: ' + response.order_id + '</div>');
                            form.reset();
                        } else {
                            $('#response').html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('<div class="alert alert-danger">Error submitting order. Please try again.</div>');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
