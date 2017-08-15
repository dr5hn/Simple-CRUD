window.ProductRow = React.createClass({
    render: function() {
        return (
            <tr>
                <td>{this.props.product.name}</td>
                <td>{this.props.product.description}</td>
                <td>${parseFloat(this.props.product.price).toFixed(2)}</td>
                <td>{this.props.product.category_name}</td>
                <td>
                    <a href="#"
                        onClick={() => this.props.changeAppMode('readOne', this.props.product.id)}
                        className="btn btn-info m-r-1em"> Read One
                    </a>
                    <a href="#"
                        onClick={() => this.props.changeAppMode('update', this.props.product.id)}
                        className="btn btn-primary m-r-1em"> Edit
                    </a>
                    <a href="#"
                        onClick={() => this.props.changeAppMode('delete', this.props.product.id)}
                        className="btn btn-danger"> Delete
                    </a>
                </td>
            </tr>
        );
    }
});