var TripLocTimeline = React.createClass({
    getInitialState: function() {
        return {
            tripLocations: []
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
                console.log(data);
                this.setState({tripLocations: data.tripLocations});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <TripLocList tripLocations={this.state.tripLocations} />
            </div>
        );
    }
});

var TripLocList = React.createClass({
    render: function() {
        var tripLocNodes = this.props.tripLocations.map(function(tripLoc) {
            return (
                <TripLocBox tripCategory={tripLoc.tripCategory} tripLocDesc={tripLoc.tripLocDesc} tripLocName={tripLoc.tripLocName} date={tripLoc.createdAt} key={tripLoc.id} pos={tripLoc.posTimeline} link={tripLoc.link}>{tripLoc.tripLocDesc}</TripLocBox>
            );
        });

        return (
            <div id="triploc-timeline" className="timeline">
                <dl>
                {tripLocNodes}
                </dl>
            </div>
        );
    }
});

var TripLocBox = React.createClass({
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
                        <h4 className="events-heading">{this.props.tripLocName} in {this.props.tripCategory}</h4>
                        <p>{this.props.tripLocDesc}</p>
                        <p><a className="btn btn-warning btn-small pull-right"  href={this.props.link}>More</a></p>
                    </div>
                </div>
            </dd>
        );
    }
});

window.TripLocTimeline = TripLocTimeline;
