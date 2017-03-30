var TripTimeline = React.createClass({
    getInitialState: function() {
        return {
            trips: []
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
                this.setState({trips: data.trips});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <TripList trips={this.state.trips} />
            </div>
        );
    }
});

var TripList = React.createClass({
    render: function() {
        var tripNodes = this.props.trips.map(function(trip) {
            return (
                <TripBox tripName={trip.tripName} tripDesc={trip.tripDesc} date={trip.createdAt} key={trip.id} pos={trip.posTimeline} link={trip.link}>{trip.tripDesc}</TripBox>
            );
        });

        return (
            <div id="trip-timeline" className="timeline">
                <dl>
                {tripNodes}
                </dl>
            </div>
        );
    }
});

var TripBox = React.createClass({
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
                        <h4 className="events-heading">{this.props.tripName}</h4>
                        <p>{this.props.tripDesc}</p>
                        <p><a href={this.props.link}>More</a></p>
                    </div>
                </div>
            </dd>
        );
    }
});

window.TripTimeline = TripTimeline;