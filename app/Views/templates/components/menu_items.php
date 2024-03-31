<section>
    <div>
        <img src="<?= $item['image_img'] ?>" alt="<?= $item['name'] ?>">
    </div>
    <h3>
        <?= $item['name'] ?>
    </h3>
    <p>
        <?= $item['description'] ?>
    </p>
    <div>
        <?php foreach ($allergy as $item['allergies']): ?>
            <div class="badge badge-outline badge-accent"></div>
        <?php endforeach; ?>
    </div>
</section>