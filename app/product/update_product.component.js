window.UpdateProductComponent = React.createClass({
    getInitialState: function() {
        return {
            categories: [],
            selectedCategoryId: 0,
            id: 0,
            name: '',
            description: '',
            price: 0,
            successUpdate: null
        };
    },

    componentDidMount: function() {

        //read categories
        this.serverRequestCat = $.get("http://localhost/Simple-CRUD/api/category/read.php",
            function(categories) {
                this.setState({
                    categories: categories.records
                });
            }.bind(this));

        //read one product data
        var productId = this.props.productId;
        this.serverRequestProd = $.get("http://localhost/Simple-CRUD/api/product/read_one.php?id=" + productId,
            function(product) {
                this.setState({selectedCategoryId: product.category_id});
                this.setState({name: product.name});
                this.setState({description: product.description});
                this.setState({price: product.price});
                this.setState({id: product.id});
            }.bind(this));

        $('.page-header h1').text('Update Product');
    },

    componentWillUnmount: function() {
        this.serverRequestProd.abort();
        this.serverRequestCat.abort();
    },

    //handling field changes
    onCategoryChange: function(e) {
        this.setState({selectedCategoryId: e.target.value});
    },

    onNameChange: function(e) {
        this.setState({name: e.target.value});
    },

    onDescriptionChange: function(e) {
        this.setState({description: e.target.value});
    },

    onPriceChange: function(e) {
        this.setState({price: e.target.value});
    },

    //handle save changes button clicked
    onSave: function(e) {

        //collect data in the form
        var form_data = {
            id: this.state.id,
            name:this.state.name,
            description:this.state.description,
            price:this.state.price,
            category_id:this.state.selectedCategoryId
        };

        //submit form data to api
        $.ajax({
            url: 'http://localhost/Simple-CRUD/api/product/update.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(form_data),
            success: function(response) {
                this.setState({successUpdate: response['message']});
            }.bind(this),
            error: function(xhr, resp, text) {
                //show error to console
                console.log(xhr,resp,text);
            }
        });

        e.preventDefault();
    },

    render: function() {
        var categoriesOptions = this.state.categories.map(function(category) {
            return (
                <option key={category.id} value={category.id}>{category.name}</option>
            );
        });

        return (
            <div>
                {
                    this.state.successUpdate == "Product was updated." ?
                    <div className='alert alert-success'>
                        Product Was Updated.
                    </div>
                    : null
                }

                {
                    this.state.successUpdate == "Unable to update product." ?
                    <div className='alert alert-danger'>
                        Unable to update product. Please try again.
                    </div>
                    : null
                }

                <a href="#"
                    onClick={() => this.props.changeAppMode('read')}
                    className='btn btn-primary m-b-1em'>
                    Read Products
                </a>

                <form onSubmit={this.onSave}>
                    <table className="table table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>
                                    <input
                                        type='text'
                                        className='form-control'
                                        required
                                        value={this.state.name}
                                        onChange={this.onNameChange} />
                                </td>
                            </tr>

                            <tr>
                                <td>Description</td>
                                <td>
                                    <textarea
                                        className='form-control'
                                        required
                                        value={this.state.description}
                                        onChange={this.onDescriptionChange}></textarea>
                                </td>
                            </tr>

                            <tr>
                                <td>Price (Rs.)</td>
                                <td>
                                    <input
                                        type='number'
                                        step='0.01'
                                        className='form-control'
                                        value={this.state.price}
                                        required
                                        onChange={this.onPriceChange} />

                                </td>
                            </tr>

                            <tr>
                                <td>Category</td>
                                <td>
                                    <select
                                        onChange={this.onCategoryChange}
                                        className='form-control'
                                        value={this.state.selectedCategoryId}>
                                        <option value="-1">Select Category.. </option>
                                        {categoriesOptions}
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <button
                                        className="btn btn-primary"
                                        onClick={this.onSave}>Save Changes</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        );
    }
});