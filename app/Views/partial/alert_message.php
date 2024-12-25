<script>
    window.addEventListener('DOMContentLoaded', function() {
        <?php
        if (session()->getFlashdata(App\Enums\StateEnum::ERROR)) {
            $message = session()->getFlashdata(App\Enums\StateEnum::ERROR);
            echo 'Toastify({
                            text: "' . $message . '",
                            duration: 5000,
                            // destination:"", redirect url
                            newWindow: true,
                            close: true,
                            gravity: "bottom", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "linear-gradient(273deg, #ff0000, #522323)"
                            },
                            // onClick: function() {} // Callback after click
                        }).showToast();';
        } elseif (session()->getFlashdata(App\Enums\StateEnum::SUCCESS)) {
            $message = session()->getFlashdata(App\Enums\StateEnum::SUCCESS);
            echo 'Toastify({
                            text: "' . $message . '",
                            duration: 5000,
                            // destination:"", redirect url
                            newWindow: true,
                            close: true,
                            gravity: "bottom", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)"
                            },
                            // onClick: function() {} // Callback after click
                        }).showToast();';
        }
        ?>
    });
</script>