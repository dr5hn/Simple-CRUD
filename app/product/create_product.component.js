window.CreateProductComponent = React.createClass({
    
    getInitialState: function() {
        return {
            categories: [],
            selectedCategoryId: -1,
            name: '',
            description: '',
            price: '',
            successCreation: null
        };
    },

    //on mount get all categories and store them in it's component state
    componentDidMount: function() {
        this.serverRequest = $.get("http://localhost/Simple-CRUD/api/category/read.php", function(categories) {
            this.setState({
                categories: categories.records
            });
        }.bind(this));

        $('.page-header h1').text("Create Product");
    },

    //on unmount stop getting categories in case the request is still loading
    componentWillUnmount: function() {
        this.serverRequest.abort();
    },

    //handle category change
    onCategoryChange: function(e) {
        this.setState({selectedCategoryId: e.target.value});
    },

    //handle name change
    onNameChange: function(e) {
        this.setState({name: e.target.value});
    },

    //handle description change
    onDescriptionChange: function(e) {
        this.setState({description: e.target.value});
    },

    //handle price change
    onPriceChange: function(e) {
        this.setState({price: e.target.value});
    },

    //handle save button clicked
    onSave: function(e) {
        //data in the form
        var form_data = {
            name : this.state.name,
            description : this.state.description,
            price : this.state.price,
            category_id : this.state.selectedCategoryId
        };

        //submit data to api
        $.ajax({
            url: "http://localhost/Simple-CRUD/api/product/create.php",
            type: "POST",
            contentType: "application/json",
            data : JSON.stringify(form_data),
            success: function(response) {
                //api message
                this.setState({successCreation: response['message']});
                //this.setState({successCreation: JSON.stringify(form_data)});

                //empty form
                this.setState({name: ""});
                this.setState({description: ""});
                this.setState({price: ""});
                this.setState({selectedCategoryId: -1});
            }.bind(this),
            error: function(xhr, resp, text) {
                //show error to console
                console.log(xhr,resp,text);
            }
        });

        e.preventDefault();
    },

    //render Component Here
    render : function() {
        //make categories as option for the select tag
        var categoriesOptions = this.state.categories.map(function(category) {
            return (
                <option key={category.id} value={category.id}>{category.name}</option>
            );
        });

        /*
            - tell the user if product was created
            - tell the user if unable to create product
            - button to go back to product list
            - form to create product
        */

        return (
        <div>
            {
                this.state.successCreation == "Product was created." ?
                    <div className="alert alert-success">
                        Product Was Saved.
                    </div>
                : null
            }

            {
                this.state.successCreation == "Unable to create product." ?
                    <div className="alert alert-danger">
                        Unable to save product. Please try again.
                    </div>
                : null
            }

            <a href="#"
                onClick={() => this.props.changeAppMode('read')}
                className="btn btn-primary m-b-1em"> Read Products
            </a>

            <form onSubmit={this.onSave}>
                <table className="table table-bordered table-hover">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={this.state.name}
                                    required
                                    onChange={this.onNameChange} />
                            </td>
                        </tr>

                        <tr>
                            <td>Description</td>
                            <td>
                                <textarea
                                    className="form-control"
                                    required
                                    value={this.state.description}
                                    onChange={this.onDescriptionChange}></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>Price (Rs.)</td>
                            <td>
                                <input
                                    type="number"
                                    step="0.01"
                                    className="form-control"
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
                                    className="form-control"
                                    value={this.state.selectedCategoryId}>
                                    <option value="-1">Select Category ... </option>
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