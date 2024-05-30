<?php $__env->startSection('content'); ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Transaksi Pembelian Token</h3>
                <p class="text-subtitle text-muted"></p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pembelian Token</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <form>
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transaksi Qris</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal">
                                <div class="form-body">
                                    <div class="row">
                                        <div align="center">
                                            <h5>Id Pelanggan : <?php echo e($idpelanggan); ?></h5></br>
                                            <h5>Nominal Token : Rp <?php echo e($nominal); ?>,00</h5>
                                        </div>
                                        <div align="center" style="margin-top:0.5cm; margin-bottom:0.5cm">
                                            <img src="<?php echo e(asset('assets/images/logo/qrislogo.png')); ?>" alt="Logo" width="150px" srcset=""><br>
                                            <?php if($qr == 'Not Found'): ?>
                                               <h3><?php echo e($keterangan); ?></h3>
                                            <?php else: ?>
                                                <?php echo e($qr); ?>

                                            <?php endif; ?>
                                        </div>
                                        <h4 align="center" style="margin-top: 0.5">Order Id : <?php echo e($orderId); ?></h1><br>
                                        <h5 align="center" id="hasil" style="margin-top: 0.5"></h1>
                                        <a href="javascript:void(0)" data-url="/status/<?php echo e($orderId); ?>" type="button" id="transaksi" class="btn btn-outline-primary block" data-target="exampleModal">
                                            Cek Status
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </form>
    <!-- // Basic Horizontal form layout section end -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).on('click', '#transaksi', function () {
        var userURL = $(this).data('url');
            $.ajax({
                url: userURL,
                type: 'GET',
                dataType: 'html',
                success: function(res) {
                    // if(res == 'PENDING')
                    // {
                    //     window.location = "/coba";
                    // }
                    // else
                    // {
                        $('#hasil').html('Status Transaksi : ' + res);
                    // }
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\bismillah\resources\views/qris.blade.php ENDPATH**/ ?>