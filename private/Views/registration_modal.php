<div class="modal fade" id="registration_modal" tabindex="-1" role="dialog" aria-labelledby="registration_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Регистрация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php include_once "registration_form.php";?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <input type="submit" form="reg_form" class="btn btn-primary" value="Зарегистрироваться">
            </div>
        </div>
    </div>
</div>
