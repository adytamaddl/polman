<?php $__env->startSection('content'); ?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Form Pembelian Token</h3>
                <p class="text-subtitle text-muted">Multiple form layout you can use</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Pembelian Token</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Basic Horizontal form layout section start -->
    <section id="basic-horizontal-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Pembelian Token</h4>
                    </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal" method="POST" action="/qris">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Id Pelanggan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="idpelanggan"
                                                    placeholder="Id Pelanggan" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nama Pelanggan</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="namapelanggan"
                                                    placeholder="Nama Pelanggan" value="<?php echo e(Auth::user()->name); ?>" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nominal</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select class="form-select" name="nominal">
                                                    <option value="20000">Rp 20.000</option>
                                                    <option value="50000">Rp 50.000</option>
                                                    <option value="100000">Rp 100.000</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary block">
                                                Bayar
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- // Basic Horizontal form layout section end -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Administrator\bismillah\resources\views/home.blade.php ENDPATH**/ ?>