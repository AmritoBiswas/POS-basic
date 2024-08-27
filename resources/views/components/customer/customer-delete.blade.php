<div class="modal animated zoomIn" id="delete-modal-customer">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class=" mt-3 text-warning">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteIdCustomer"/>
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button type="button" id="delete-modal-close-customer" class="btn bg-gradient-success mx-2" data-bs-dismiss="modal">Cancel</button>
                    <button onclick="itemDelete()" type="button" id="confirmDeleteCustomer" class="btn bg-gradient-danger" >Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete(){
        let id = document.getElementById('deleteIdCustomer').value;
        document.getElementById('delete-modal-close-customer').click();

        showLoader();

        let res = await axios.post('/delete-customer',{id:id});

        hideLoader();

        if(res.data == 1){
            successToast("Customer Deleted Successfully");
            await getList();
        }

        else{
            errorToast("Some thing went Wrong!");
        }
    }
</script>
