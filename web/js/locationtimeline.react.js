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
                <LocationLocBox tripCategory={location.tripCategory} tripLocDesc={location.tripLocDesc} tripLocName={location.tripLocName} tripLocImg={location.tripLocImg} tripLatLon={location.tripLatLon} date={location.createdAt} key={location.id} pos={location.posTimeline}  link={location.link} linkCat={location.linkCat} linkTrip={location.linkTrip}></LocationLocBox>
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
                    <div className="events-image"><ImageLocBox locImages={this.props.tripLocImg} id={this.props.key}></ImageLocBox></div>
                    <div className="pull-left">
                        <img className="events-object img-rounded" width="50" src="/img/placeholder.jpg" />
                    </div>
                    <div className="events-body">
                        <h4 className="events-heading">{this.props.tripLocName}</h4>
                        <p>{this.props.tripLocDesc}</p>
                        <i className="fa fa-tag fa-2" aria-hidden="true"></i> <a href={this.props.linkCat}>{this.props.tripCategory}</a>
                        <p>
                            <a className="btn btn-primary btn-small pull-left" href={this.props.linkTrip}>View trip</a>
                            <a className="btn btn-primary btn-small pull-right" href={this.props.link}>View location detail</a>
                        </p>
                    </div>
                </div>
            </dd>
        );
    }
});

var ImageLocBox = React.createClass({
    render: function() {
        var locImages = this.props.locImages.map(function(locImage){
            return (<div className="item"><img src={locImage} /></div>);
        });

        return(
            <div className="gallery">{locImages}</div>
        );
    }

});

window.LocationTimeline = LocationTimeline;
