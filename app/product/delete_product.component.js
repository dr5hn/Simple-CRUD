window.DeleteProductComponent = React.createClass({
    componentDidMount: function() {
        $('.page-header h1').text('Delete Product');
    },

    onDelete: function(e) {
        //product to delete
        var productId = this.props.productId;

        //submit data to ajax API
        $.ajax({
            url: "http://localhost/Simple-CRUD/api/product/delete.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({'id':productId}),
            success: function(response) {
                this.props.changeAppMode('read');
            }.bind(this),
            error: function(xhr,resp,text) {
                //show error in console
                console.log(xhr,resp,text);
            }
        });
    },

    render: function() {
        return (
            <div className="row">
                <div className="col-md-3"></div>
                <div className="col-md-6">
                    <div className="panel panel-default">
                        <div className="panel-body text-center">
                            Are You Sure ?
                        </div>
                        <div className="panel-footer clearfix">
                            <div className="text-center">
                                <button onClick={this.onDelete} className="btn btn-danger m-r-1em">Yes</button>
                                <button onClick={() => this.props.changeAppMode('read')} className="btn btn-primary">No</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-3"></div>
            </div>
        );
    }
});