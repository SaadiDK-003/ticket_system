<?php
require_once '../core/database.php';

if (isset($_POST['category_name'])):
    echo add_category($_POST);
endif;

if (isset($_POST['cat_id'])):

    $cat_id = $_POST['cat_id'];
    $get_sub_Q = $db->query("CALL `get_sub_categories`($cat_id)");
    if (mysqli_num_rows($get_sub_Q) > 0):
?>
        <select class="form-select select2" name="subCat[]" multiple>
            <?php
            while ($subCat = mysqli_fetch_object($get_sub_Q)):
            ?>
                <option value="<?= $subCat->sub_cat_name ?>"><?= $subCat->sub_cat_name ?></option>
                <!-- <div class="d-flex align-items-center gap-2 mb-u">
                <input type="checkbox" name="subCat[]" id="subCat-< ?= $subCat->sub_id ?>" value="< ?= $subCat->sub_cat_name ?>">
                <label for="subCat-< ?= $subCat->sub_id ?>" class="label">< ?= $subCat->sub_cat_name ?></label>
            </div> -->
            <?php
            endwhile; ?>
        </select>
<?php
    endif;
endif;
