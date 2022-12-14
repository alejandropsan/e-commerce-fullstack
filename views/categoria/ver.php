<?php if (isset($categoria_match)): ?>
    <h1><?= $categoria_match->nombre ?></h1>
    <?php if ($productos->num_rows == 0): ?>
        <p>No hay productos para mostrar</p>
    <?php else: ?>
        
        <?php while ($product = $productos->fetch_object()): ?>
            <div class="product">
                <?php if ($product->imagen != null): ?>
                    <img src="<?= base_url ?>uploads/images/<?= $product->imagen ?>" />
                <?php else: ?> 
                    <img src="assets/img/camiseta.png" />
                <?php endif; ?>
                <h2><?= $product->nombre ?></h2>
                <p><?= $product->precio ?></p>
                <a href="" class="button">Comprar</a>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
<?php else: ?>
    <h1>La categoría no existe</h1>
<?php endif; ?>
