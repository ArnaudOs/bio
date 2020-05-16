

<?php foreach ($products as $product) : ?>
    <tr>
        <td>
            <h3> <?= $product->title ?> (<?= $product->price ?> €) </h3>
        </td>

            <td>
                <input type="hidden" name="id" value="<?= ucfirst(strtolower($product->id)) ?>" class="formpanier">
                <input type="number" name="quantity" id="" placeholder="quantité"  min="0" size="3" class="formpanier">

                <button type="submit"><strong>+</strong></button>
            </td>
    </tr>
   
    </form>
<?php endforeach ?>