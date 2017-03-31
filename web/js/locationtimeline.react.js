var LocationTimeline = React.createClass({
    getInitialState: function() {
        return {
            locations: []
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
                this.setState({locations: data.locations});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <LocationList locations={this.state.locations} />
            </div>
        );
    }
});

var LocationList = React.createClass({
    render: function() {
        var locationNodes = this.props.locations.map(function(location) {
            return (
                <LocationLocBox tripCategory={location.tripCategory} tripLocDesc={location.tripLocDesc} tripLocName={location.tripLocName} date={location.createdAt} key={location.id} pos={location.posTimeline} link={location.link}>{location.tripLocDesc}</LocationLocBox>
            );
        });

        return (
            <div id="location-timeline" className="timeline">
                <dl>
                {locationNodes}
                </dl>
            </div>
        );
    }
});

var LocationLocBox = React.createClass({
    render: function() {
        return (
            <dd className={this.props.pos}>
                <div className="circ"></div>
                <div className="time">{this.props.date}</div>
                <div className="events">
                    <div className="pull-left">
                        <img className="events-object img-rounded" width="50" src="/img/placeholder.jpg" />
                    </div>
                    <div className="events-body">
                        <h4 className="events-heading">{this.props.tripLocName}</h4>
                        <p>{this.props.tripLocDesc}</p>
                        <i className="fa fa-tag fa-2" aria-hidden="true"></i> {this.props.tripCategory}
                        <p><a className="btn btn-success btn-small pull-right" href={this.props.link}>More</a></p>
                    </div>
                </div>
            </dd>
        );
    }
});

window.LocationTimeline = LocationTimeline;
