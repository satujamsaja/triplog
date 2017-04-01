var Categories = React.createClass({
    getInitialState: function() {
        return {
            categories: []
        }
    },

    componentDidMount: function() {
        this.loadTripsFromServer();
        setInterval(this.loadTripsFromServer, 2000);
    },

    loadTripsFromServer: function() {
        $.ajax({
            url: this.props.url,
            success: function (data) {
                this.setState({categories: data.categories});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <CategoriesList categories={this.state.categories} />
            </div>
        );
    }
});

var CategoriesList = React.createClass({
    render: function() {
        var categoriesNodes = this.props.categories.map(function(category) {
            return (
                <CategoryBox tripCatName={category.tripCatName} key={category.id} link={category.link}>{category.tripCatName}</CategoryBox>
            );
        });

        return (
            <div id="categories-box">
                <dl>
                {categoriesNodes}
                </dl>
            </div>
        );
    }
});

var CategoryBox = React.createClass({
    render: function() {
        return (
            <div className="col-sm-6 col-md-3">
                <div className="thumbnail">
                    <img className="img-rounded" src="/img/placeholder.jpg" />
                        <div className="caption text-center">
                            <h2>{this.props.tripCatName}</h2>
                            <p><a href={this.props.link} className="btn btn-warning btn-small" role="button">View locations</a></p>
                        </div>
                </div>
            </div>
        );
    }
});

window.Categories = Categories;
