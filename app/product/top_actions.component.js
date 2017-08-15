//components that contain functionalities that appear on top of the product table: create product

window.TopActionsComponent = React.createClass({
    render:function() {
        return (
            <div>
                <a href="#"
                    onClick={() => this.props.changeAppMode('create')}
                    className='btn btn-primary m-b-1em'> Create Product
                </a>
            </div>
        );
    }
});