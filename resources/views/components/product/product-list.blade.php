<div class="container-fluid">
    <div class="row">
    <div class="col-md-12 col-sm-12 col-lg-12">
        <div class="card px-5 py-5">
            <div class="row justify-content-between ">
                <div class="align-items-center col">
                    <h4>Product</h4>
                </div>
                <div class="align-items-center col">
                    <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0  bg-gradient-primary">Create</button>
                </div>
            </div>
            <hr class="bg-dark "/>
            <table class="table" id="tableData">
                <thead>
                <tr class="bg-light">
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Unit</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="tableList">

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<script>
    getList();
    async function getList(){
        showLoader();
        let res = await axios.get('/product-list');
        
        hideLoader();



        let tableList = $('#tableList');
        let tableData = $('#tableData');

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(product,index){
            
            let row =  `<tr>
                        <td><img class="w-15 h-15" src="${product['img_url']}"/></td>
                        <td>${product['name']}</td>
                        <td>${product['price']}</td>
                        <td>${product['unit']}</td>
                        <td>
                        <button data-path="${product['img_url']}" data-id="${product['id']}" class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-path="${product['img_url']}" data-id="${product['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                        </tr>`
           
        tableList.append(row);
        })

        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });


        $(".deleteBtn").on('click',function(){
            let id = $(this).data('id');
            
            let path = $(this).data('path');
            

            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
            $("#deleteFilePath").val(path);
        })

        $(".editBtn").on('click', async function(){
            let id = $(this).data('id');
            let path = $(this).data('path');
            await FillUpUpdateForm(id,path)
           $("#update-modal").modal('show');
         

        })

        
        
    }
</script>

