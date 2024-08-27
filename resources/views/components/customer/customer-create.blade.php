<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Create Customer</h6>
                </div>
                <div class="modal-body">
                    <form id="save-form-update">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email</label>
                                <input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile</label>
                                <input type="text" class="form-control" id="customerMobile">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close-customer" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn-customer" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>
    async function Save(){
        let customerName = document.getElementById('customerName').value;
        let customerEmail = document.getElementById('customerEmail').value;
        let customerMobile = document.getElementById('customerMobile').value;

        if(customerName.length === 0){
            errorToast("Customer Name Required");
        }
        if(customerEmail.length === 0){
            errorToast("Email Name Required");
        }
        if(customerMobile.length === 0){
            errorToast("Customer Mobile Required");
        }

        else{
            document.getElementById('modal-close-customer').click();
            showLoader();
            let res = await axios.post('/create-customer',{
                name:customerName,
                email:customerEmail,
                mobile:customerMobile
            });
            hideLoader();
            if(res.status === 201){
                successToast('Customer added Successful');
                document.getElementById('save-form-update').reset();

                await getList();
            }

            else{
                errorToast("Request failed");
            }
        }
    }
</script>
