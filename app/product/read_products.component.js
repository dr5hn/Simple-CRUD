//component that contains all the logic and other small components that forms the REACT product view

window.ReadProductsComponent = React.createClass({
    getInitialState: function() {
        return {
            products: []
        };
    },

    //on mount fetch all products and store them as this components state
    componentDidMount: function() {
        this.serverRequest = $.get("http://localhost/Simple-CRUD/api/product/read.php", function(products) {
            this.setState({
                products: products.records
            });
        }.bind(this));
    },

    //on unmount kill products fetching in case request is still pending
    componentWillUnmount: function() {
        this.serverRequest.abort();
    },

    //render components on page
    render: function() {
        //list produtcs
        var filteredProducts = this.state.products;
        $('.page-header h1').text("Read Products");

        return (
            <div className='overflow-hidden'>
                <TopActionsComponent changeAppMode = {this.props.changeAppMode} />

                <ProductsTable
                    products={filteredProducts}
                    changeAppMode={this.props.changeAppMode} />
            </div>
        );

    }

});