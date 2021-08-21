<?php
# This is the engine name.  This should be set if you have more than one engine running in the same JVM.
# It is used to name the JMX management bean.  Please do not use underscores in this name.
#
# Tags: general
engine.name=SymmetricDS

# The node group id that this node belongs to
# Tags: init
group.id=please set me

# The external id for this SymmetricDS node.  The external id is
# usually used as all or part of the node id.
# Tags: init
external.id=please set me

# This is the URL this node will use to register and pull it's configuration.
# If this is the root server, then this may remain blank and the configuration
# should be inserted directly into the database
# Tags: init
registration.url=please set me

# The url that can be used to access this SymmetricDS node.
# The default setting of http://$(hostName):31415/sync should be
# valid of the standalone launcher is used with the default settings
# The tokens of $(hostName) and $(ipAddress) are supported for this property.
# Tags: init
#sync.url=http://$(hostName):31415/sync/$(engineName)

# Specify your database driver
# Tags: database
db.driver=org.h2.Driver
#db.driver=org.h2.Driver
#db.driver=com.mysql.jdbc.Driver
#db.driver=oracle.jdbc.driver.OracleDriver
#db.driver=org.postgresql.Driver
#db.driver=org.apache.derby.jdbc.EmbeddedDriver
#db.driver=org.hsqldb.jdbcDriver
#db.driver=net.sourceforge.jtds.jdbc.Driver
#db.driver=com.ibm.db2.jcc.DB2Driver
#db.driver=org.sqlite.JDBC
#db.driver=org.firebirdsql.jdbc.FBDriver

# Specify your database URL
# Tags: database
db.url=jdbc:h2:mem:setme;AUTO_SERVER=TRUE
#db.url=jdbc:h2:file:target/h2/client
#db.url=jdbc:oracle:thin:@127.0.0.1:1521:sampleroot
#db.url=jdbc:postgresql://localhost/sampleroot
#db.url=jdbc:derby:sampleroot;create=true
#db.url=jdbc:hsqldb:file:sampleroot;shutdown=true
#db.url=jdbc:jtds:sqlserver://localhost:1433;useCursors=true;bufferMaxMemory=10240;lobBuffer=5242880
#db.url=jdbc:db2://localhost/samproot
#db.url=jdbc:mysql://localhost/sampleroot?tinyInt1isBit=false
#db.url=jdbc:sqlite:target/sqlite/client
#db.url=jdbc:firebirdsql://host[:port]/<database>

# Specify your database user
# Tags: database
db.user=please set me

# Specify your database password
# Tags: database
db.password=

# The initial size of the connection pool
# Tags: database
db.pool.initial.size=100

# The maximum number of connections that will be allocated in the pool
# The http.concurrent.workers.max value should be half or less than half of
# this value.
# Tags: database
db.pool.max.active=600

# The maximum number of connections that can remain idle in the pool, without extra ones 
# being released
# Tags: database
db.pool.max.idle=20

# The minimum number of connections that can remain idle in the pool, without extra ones 
# being created
# Tags: database
db.pool.min.idle=5

# This is the query to validate the database connection in Connection Pool.
# It is database specific.  The following are example statements for different databases.
#
# MySQL
#  db.validation.query=select 1
# Oracle
#  db.validation.query=select 1 from dual
# DB2
#  db.validation.query=select max(1) from syscat.datatypes
# Tags: database
db.validation.query=

# These are settings that will be passed to the JDBC driver as connection properties.
# Suggested settings by database are as follows:
# Oracle
#
#  db.connection.properties=oracle.net.CONNECT_TIMEOUT=300000;oracle.net.READ_TIMEOUT=300000;SetBigStringTryClob=true;includeSynonyms=true
# Tags: database
db.connection.properties=

# Specify a SQL statement that will be run when a database connection is created
#
# Tags: database
db.init.sql=

# When symmetric tables are created and accessed, this is the prefix to use for the tables.
#
# Tags: database
sync.table.prefix=sym

# Most symmetric queries have a timeout associated with them.  This is the default.
# Tags: database
db.sql.query.timeout.seconds=300

# Name of class that can extract native JDBC objects and interact directly with the driver.
# Spring uses this to perform operations specific to database, like handling LOBs on Oracle.
#
# Tags: database
db.native.extractor=org.springframework.jdbc.support.nativejdbc.CommonsDbcpNativeJdbcExtractor

# This is how long a request for a connection from the datasource will wait before
# giving up.
#
# Tags: database
db.pool.max.wait.millis=30000

# This is how long a connection can be idle before it will be evicted.
# Tags: database
db.pool.min.evictable.idle.millis=120000

# This is the default fetch size for streaming result sets.
#
# Tags: database
db.jdbc.streaming.results.fetch.size=100

# This is the default number of rows that will be sent to the database as a batch when
# SymmetricDS uses the JDBC batch API.  Currently, only routing uses JDBC batch.  The
# data loader does not.
#
# Tags: database,routing
db.jdbc.execute.batch.size=100

# Indicates that case should be ignored when looking up references to tables using the database's metadata api.
#
# Tags: database
# Type: boolean
db.metadata.ignore.case=true

# Determines whether delimited identifiers are used or normal SQL92
# identifiers (which may only contain alphanumerical characters and the
# underscore, must start with a letter and cannot be a reserved keyword).
#
# Tags: database
# Type: boolean
db.delimited.identifier.mode=true

# This is the number of HTTP concurrent push/pull requests SymmetricDS will accept.  This is controlled
# by the NodeConcurrencyFilter. The number is per servlet the filter is applied to.  The
# db.pool.max.active value should be twice this value.
#
# DatabaseOverridable: true
# Tags: transport
http.concurrent.workers.max=150

# This is the amount of time the host will keep a concurrent connection reservation after it has
# been attained by a client node while waiting for the subsequent reconnect to push.
# Tags: transport
http.concurrent.reservation.timeout.ms=20000

# During SSL handshaking, if the URL's hostname and the server's
# identification hostname mismatch, the verification mechanism
# will check this comma separated list of server names to see if the
# cert should be accepted (see javax.net.ssl.HostnameVerifier.)
# Set this value equal to 'all' if all server names should be accepted.
# Set this value to blank if a valid SSL cert is required.
# Tags: transport
https.verified.server.names=

# Save data to the file system before transporting it to the client or loading
# it to the database if the number of bytes is past a certain threshold.  This allows
# for better compression and better use of database and network resources.  Statistics
# in the batch tables will be more accurate if this is set to true because each timed
# operation is independent of the others.
#
# DatabaseOverridable: true
# Tags: transport
# Type: boolean
stream.to.file.enabled=true

# If stream.to.file.enabled is true, then the threshold number of bytes at which a file
# will be written is controlled by this property.  Note that for a synchronization the
# entire payload of the synchronization will be buffered in memory up to this number (at
# which point it will be written and continue to stream to disk.)
#
# DatabaseOverridable: true
# Tags: transport
stream.to.file.threshold.bytes=32767

# If stream.to.file.enabled is true, then this is how long a file will be retained in the
# staging directory after it has been marked as done.
#
# DatabaseOverridable: true
# Tags: transport
stream.to.file.ttl.ms=3600000

# This is the number of times we will attempt to send an ACK back to the remote node
# when pulling and loading data.
#
# DatabaseOverridable: true
# Tags: transport
num.of.ack.retries=5

# This is the amount of time to wait between trying to send an ACK back to the remote node
# when pulling and loading data.
#
# DatabaseOverridable: true
# Tags: transport
time.between.ack.retries.ms=5000

# Sets both the connection and read timeout on the internal HttpUrlConnection
#
# DatabaseOverridable: true
# Tags: transport
http.timeout.ms=7200000

# Whether or not to use compression over HTTP connections.
# Currently, this setting only affects the push connection of the source node.
# Compression on a pull is enabled using a filter in the web.xml for the PullServlet.
# @see web.compression.disabled to enable/disable the filter
#
# DatabaseOverridable: true
# Tags: transport
# Type: boolean
http.compression=true

# The HTTP client connection, during a push, buffers the entire outgoing pay-load locally
# before sending it.  Set this to true if you are getting heap space errors during
# a push.  Note that basic auth may not work when this is turned on.
#
# DatabaseOverridable: true
# Tags: transport
# Type: boolean
http.push.stream.output.enabled=true

# When HTTP chunking is turned on, this is the size to use for each chunk.
#
# DatabaseOverridable: true
# Tags: transport
http.push.stream.output.size=30720

# Disable compression from occurring on Servlet communication.  This property only
# affects the outbound HTTP traffic streamed by the PullServlet and PushServlet.
#
# DatabaseOverridable: true
# Tags: transport
# Type: boolean
web.compression.disabled=false

# Set the compression level this node will use when compressing synchronization payloads.
# @see java.util.zip.Deflater
# NO_COMPRESSION = 0
# BEST_SPEED = 1
# BEST_COMPRESSION = 9
# DEFAULT_COMPRESSION = -1
#
# DatabaseOverridable: true
# Tags: transport
compression.level=-1

# Set the compression strategy this node will use when compressing synchronization payloads.
# @see java.util.zip.Deflater
# FILTERED = 1
# HUFFMAN_ONLY = 2
# DEFAULT_STRATEGY = 0
#
# DatabaseOverridable: true
# Tags: transport
compression.strategy=0

# Indicate whether the batch servlet (which allows specific batches to be requested) is enabled.
#
# Tags: other
# Type: boolean
web.batch.servlet.enable=true

# Specify the transport type.  Supported values currently include: http, internal.
#
# Tags: transport
transport.type=http

# This is the number of maximum number of bytes to synchronize in one connect.
#
# DatabaseOverridable: true
# Tags: transport
transport.max.bytes.to.sync=1048576

# If this is true, when symmetric starts up it will try to create the necessary tables.
#
# Tags: general
# Type: boolean
auto.config.database=true

# If this is true. when symmetric starts up it will make sure the triggers in the database are up to date.
#
# Tags: general
# Type: boolean
auto.sync.triggers=true

# If this is true, when a symmetric node other than the registration server
# starts up and the minor release number has incremented, then the node will
# request a reload of key symmetric tables (because there might be new tables or
# columns.)
#
# Tags: general
# Type: boolean
auto.reload.sym.tables.on.upgrade=true

# Capture and send SymmetricDS configuration changes to client nodes.
#
# Tags: general
# Type: boolean
auto.sync.configuration=true

# Whether triggers should fire when changes sync into the node that this property is configured for.
#
# DatabaseOverridable: true
# Tags: general
# Type: boolean
auto.sync.configuration.on.incoming=true

# Update the node row in the database from the local properties during a heartbeat operation.
#
# Tags: general
# Type: boolean
auto.update.node.values.from.properties=false

# If this is true, then node, group, security and identity rows will be inserted if the
# registration.url is blank and there is no configured node identity.
#
# Tags: general
# Type: boolean
#auto.insert.registration.svr.if.not.found=false

# Provide the path to a SQL script that can be run to do initial setup of a registration server.  This script
# will only be run on a registration server if the node_identity cannot be found.
#
# Tags: general
auto.config.registration.svr.sql.script=

# This is hook to give the user a mechanism to indicate the schema version that is being synchronized.
#
# DatabaseOverridable: true
#
# Tags: other
schema.version=?

# This is the number of times registration will be attempted before being aborted.  The default
# value is -1 which means an endless number of attempts.  This parameter is specific to the node
# that is trying to register, not the node that is providing registration.
#
# DatabaseOverridable: true
# Tags: registration
registration.number.of.attempts=-1

# Indicates whether SymmetricDS should be re-initialized immediately before registration.
#
# DatabaseOverridable: true
# Tags: registration
# Type: boolean
registration.reinitialize.enable=false

# Set this if tables should be created prior to an initial load.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
initial.load.create.first=false

# Set this if tables should be purged prior to an initial load.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
initial.load.delete.first=false

# This is the SQL statement that will be used for purging a table
# during an initial load.
#
# DatabaseOverridable: true
# Tags: load
initial.load.delete.first.sql=delete from %s

# Indicate that the initial load events should be put on the reload channel.
# If this is set to false each table will be put on it's assigned channel during
# the reload.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
initial.load.use.reload.channel=true

# Indicate that if both the initial load and the reverse initial load
# are requested, then the reverse initial load should take place first.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
initial.load.reverse.first=true

# If this is true, registration is opened automatically for nodes requesting it.
#
# DatabaseOverridable: true
# Tags: registration
# Type: boolean
auto.registration=false

# If this is true, a reload is automatically sent to nodes when they register
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
auto.reload=false

# If this is true, a reload is automatically sent from a source node
# to all target nodes after the source node has registered.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
auto.reload.reverse=false

# Indicate whether the process of inserting data, data_events and outgoing_batches for
# a reload is transactional.  The only reason this might be marked as false is to reduce
# possible contention while multiple nodes connect for reloads at the same time.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
datareload.batch.insert.transactional=true

# Set this if you want to give your server a unique name to be used to identify which server did what action.  Typically useful when running in
# a clustered environment.  This is currently used by the ClusterService when locking for a node.
#
# Tags: jobs
cluster.server.id=

# Indicate that this node is being run on a farm or cluster of servers and it needs to use the database to 'lock' out other activity when actions are taken.
#
# DatabaseOverridable: true
# Tags: jobs
cluster.lock.timeout.ms=1800000

# Enables clustering of jobs.
#
# DatabaseOverridable: true
# Tags: jobs
# Type: boolean
cluster.lock.enabled=false

# If jobs need to be synchronized so that only one job can run at a time, set this parameter to true
#
# DatabaseOverridable: true
# Tags: jobs
# Type: boolean
jobs.synchronized.enable=false

# This is how often the push job will be run to schedule pushes to nodes.
#
# DatabaseOverridable: true
# Tags: jobs
job.push.period.time.ms=60000

# This is the minimum time that is allowed between pushes to a specific node.
#
# DatabaseOverridable: true
# Tags: jobs
push.period.minimum.ms=0

# This is how often the pull job will be run to schedule pulls of nodes.
#
# DatabaseOverridable: true
# Tags: jobs
job.pull.period.time.ms=60000

# This is the minimum time that is allowed between pulls of a specific node.
#
# DatabaseOverridable: true
# Tags: jobs
pull.period.minimum.ms=0

# This is how often accumulated statistics will be flushed out to the database from memory.
#
# DatabaseOverridable: true
# Tags: jobs
job.stat.flush.cron=0 0/5 * * * *

# This is how often the router will run in the background
#
# DatabaseOverridable: true
# Tags: jobs
job.routing.period.time.ms=10000

# This is how often the heartbeat job runs.  Note that this doesn't mean that a heartbeat
# is performed this often.
# see heartbeat.sync.on.push.period.sec to change how often the heartbeat is sync'd
#
# DatabaseOverridable: true
# Tags: jobs
job.heartbeat.cron=0 0/15 * * * *

# DatabaseOverridable: true
# Tags: jobs
job.watchdog.period.time.ms=3600000

# This is how often the data gaps purge job will be run.
#
# DatabaseOverridable: true
# Tags: jobs
job.purge.datagaps.cron=0 0 0 * * *

# This is how often the incoming batch spurge job will be run.
#
# DatabaseOverridable: true
# Tags: jobs
job.purge.incoming.cron=0 0 0 * * *

# This is how often the outgoing batch and data purge job will be run.
#
# DatabaseOverridable: true
# Tags: jobs
job.purge.outgoing.cron=0 0 0 * * *

# This is when the sync triggers job will run.
#
# DatabaseOverridable: true
# Tags: jobs
job.synctriggers.cron=0 0 0 * * *

# This is when the refresh cache job will run.
#
# DatabaseOverridable: true
# Tags: jobs
job.refresh.cache.cron=0/30 * * * * *

# This is when the stage management job will run.
#
# DatabaseOverridable: true
# Tags: jobs
job.stage.management.period.time.ms=15000

# This is the number of batches that will be purged from the data_event table in one database transaction.
#
# DatabaseOverridable: true
# Tags: purge, jobs
job.purge.max.num.data.event.batches.to.delete.in.tx=5

# This is the number of batches that will be purged in one database transaction.
#
# DatabaseOverridable: true
# Tags: purge, jobs
job.purge.max.num.batches.to.delete.in.tx=5000

# This is the number of data ids that will be purged in one database transaction.
#
# DatabaseOverridable: true
# Tags: purge
job.purge.max.num.data.to.delete.in.tx=5000

# Whether the refresh cache job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.refresh.cache.job=false

# Whether the routing job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.route.job=true

# Whether the pull job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.pull.job=true

# Whether the push job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.push.job=true

# Whether the purge job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.purge.job=true

# Whether the heartbeat job is enabled for this node.  The heartbeat job simply
# inserts an event to update the heartbeat_time column on the node table for the current node.
#
# Tags: jobs
# Type: boolean
start.heartbeat.job=true

# Whether the sync triggers job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.synctriggers.job=true

# Whether the statistic flush job is enabled for this node.
#
# Tags: jobs
start.stat.flush.job=true

# Whether the watchdog job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.watchdog.job=true

# Whether the stage management job is enabled for this node.
#
# Tags: jobs
# Type: boolean
start.stage.management.job=true

# The number of threads created that will be used to pull nodes concurrently on one server in the cluster.
#
# DatabaseOverridable: true
# Tags: jobs
pull.thread.per.server.count=1

# The amount of time a single pull worker node_communication lock will timeout after.
#
# DatabaseOverridable: true
# Tags: jobs
pull.lock.timeout.ms=7200000

# The number of threads created that will be used to push to nodes concurrently on one server in the cluster.
#
# DatabaseOverridable: true
# Tags: jobs
push.thread.per.server.count=10

# The amount of time a single push worker node_communication lock will timeout after.
#
# DatabaseOverridable: true
# Tags: jobs
# Tags: jobs
push.lock.timeout.ms=7200000

# This is the maximum number of events that will be peeked at to look for additional transaction rows after
# the max batch size is reached.  The more concurrency in your db and the longer the transaction takes the
# bigger this value might have to be.
#
# DatabaseOverridable: true
# Tags: routing
routing.peek.ahead.window.after.max.size=2000

# DatabaseOverridable: true
# Tags: routing
routing.wait.for.data.timeout.seconds=330

# DatabaseOverridable: true
# Tags: routing
routing.flush.jdbc.batch.size=50000

# This is the number of gaps that will be included in the SQL that is used to select data
# from sym_data.  If there are more gaps than this number, then the last gap will in the SQL
# will use the end id of the last gap.
#
# DatabaseOverridable: true
# Tags: routing
routing.max.gaps.to.qualify.in.sql=100

# This is the time that any gaps in data_ids will be considered stale and skipped.
#
# DatabaseOverridable: true
# Tags: routing
routing.stale.dataid.gap.time.ms=7200000

# DatabaseOverridable: true
# Tags: routing
routing.data.reader.type.gap.retention.period.minutes=1440

# When true, delete the gaps instead of marking them as OK or SK.
#
# DatabaseOverridable: true
# Tags: routing
routing.delete.filled.in.gaps.immediately=true

# This is the maximum number of data that will be routed during one run.  It should be a number that well
# exceeds the number rows that will be in a transaction.
#
# DatabaseOverridable: true
# Tags: routing
routing.largest.gap.size=50000000

# Use the order by clause to order sym_data when selecting data for routing.  Most databases
# order the data naturally and might even have better performance when the order by clause is
# left off.
#
# DatabaseOverridable: true
# Tags: routing
# Type: boolean
routing.data.reader.order.by.gap.id.enabled=true

# Select data to route from sym_data using a simple > start_gap_id query if
# the number of gaps in sym_data_gap are greater than the following number
#
# DatabaseOverridable: true
# Tags: routing
routing.data.reader.threshold.gaps.to.use.greater.than.query=100

# This is the number of data events that will be batched and committed together while building a batch.
# Note that this only kicks in if the prospective batch size is bigger than the configured max batch size.
#
# DatabaseOverridable: true
# Tags: extract
outgoing.batches.peek.ahead.batch.commit.size=10

# Disable the extraction of all channels with the exception of the config channel
#
# DatabaseOverridable: true
# Tags: extract
# Type: boolean
dataextractor.enable=true

# This instructs symmetric to attempt to skip duplicate batches that are received.  Symmetric might
# be more efficient when recovering from error conditions if this is set to true, but you run the
# risk of missing data if the batch ids get reset (on one node, but not another) somehow (which is unlikely in production, but
# fairly likely in lab or development setups).
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
incoming.batches.skip.duplicates=true

# Disable the loading of all channel with the exception of the config channel.  This
# property can be set to allow all changes to be extracted without introducing other
# changes in order to allow maintenance operations.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
dataloader.enable=true

# Tables that are missing at the target database will be ignored.  This should be set to
# true if you expect that in some clients a table might not exist.  If set to false, the
# batch will fail.
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
dataloader.ignore.missing.tables=false

# This is the maximum number of rows that will be supported in a
# single transaction.  If the database transaction row count reaches a size
# that is greater than this number then the transaction will be auto committed.
# The default value of -1 indicates that there is no size limit.
#
# DatabaseOverridable: true
# Tags: load
dataloader.max.rows.before.commit=10000

# Amount of time to sleep before continuing data load after dataloader.max.rows.before.commit rows have been loaded.
# This is useful to give other application threads a chance to do work before continuing to load.
#
# DatabaseOverridable: true
# Tags: load
dataloader.sleep.time.after.early.commit=5

# Indicates that the current value of the row should be recorded in the incoming_error table
#
# DatabaseOverridable: true
# Tags: load
# Type: boolean
dataloader.error.save.curval=false

# The number of milliseconds parameters will be cached by the ParameterService before they are reread from the
# file system and database.
#
# DatabaseOverridable: true
# Tags: other
parameter.reload.timeout.ms=600000

# This is the amount of time node security entries will be cached before re-reading
# them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.node.security.time.ms=0

# This is the amount of time grouplet entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.grouplets.time.ms=600000

# This is the amount of time trigger entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.trigger.router.time.ms=600000

# This is the amount of time transform entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.transform.time.ms=600000

# This is the amount of time load filter entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.load.filter.time.ms=600000

# This is the amount of time conflict setting entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.conflict.time.ms=600000

# This is the amount of time table meta data will be cached before re-reading it from the database
#
# DatabaseOverridable: false
# Tags: other
cache.table.time.ms=3600000

# This is the amount of time channel entries will be cached before re-reading them from the database.
#
# DatabaseOverridable: true
# Tags: other
cache.channel.time.ms=60000

# When starting jobs, symmetric attempts to randomize the start time to spread out load.  This is the
# maximum wait period before starting a job.
# Tags: jobs
job.random.max.start.time.ms=10000

# This is the retention for how long synchronization data will be kept in the symmetric synchronization
# tables.  Note that data will be purged only if the purge job is enabled.
#
# DatabaseOverridable: true
# Tags: purge
purge.retention.minutes=7200

# This is the retention for how long statistic data will be kept in the symmetric stats
# tables.  Note that data will be purged only if the statistics flush job is enabled.
#
# DatabaseOverridable: true
# Tags: purge
purge.stats.retention.minutes=7200

# If using the HsqlDbDialect, this property indicates whether Symmetric should setup the embedded database properties or if an
# external application will be doing so.
# Tags: other
# Type: boolean
hsqldb.initialize.db=true

# This is the precision that is used in the number template for oracle triggers
# Tags: other
oracle.template.precision=30,10

# Requires access to gv$transaction
# Tags: other
# Type: boolean
oracle.use.transaction.view=false

# Requires access to gv$transaction.  This is the threshold by which clock can be off in
# an oracle rac environment.  It is only applicable when oracle.use.transaction.view is set
# to true.
# Tags: other
# Type: boolean
oracle.transaction.view.clock.sync.threshold.ms=60000

# Use to map the version string a zseries jdbc driver returns to the 'zseries' dialect
# Tags: other
db2.zseries.version=DSN08015

# Specify the type of line feed to use in JMX console methods.  Possible values are: text or html.
# Tags: other
jmx.line.feed=text

# Specify whether to push node records to configured push clients.  If this is true
# the node for this instance and the node rows for all children instances will be pushed
# to all nodes that this node is configured to push to.
# DatabaseOverridable: true
# Tags: other
# Type: boolean
heartbeat.sync.on.push.enabled=true

# This is the number of seconds between when the sym_node table's heartbeat_time column is
# updated.
# DatabaseOverridable: true
# Tags: other
heartbeat.sync.on.push.period.sec=0

# When this property is set to true the heartbeat process will run at server startup.  Prior to 3.4
# the heartbeat always happened at startup.
# DatabaseOverridable: true
# Tags: other
heartbeat.sync.on.startup=false

# When this is set to true, SymmetricDS will update fields in the sym_node table that indicate the
# number of outstanding errors and/or batches it has pending 
# DatabaseOverridable: true
# Tags: other
# Type: boolean
heartbeat.update.node.with.batch.status=true

# This is the number of minutes that a node has been offline before taking action
# A value of -1 (or any negative value) disables the feature.
# DatabaseOverridable: true
# Tags: other
offline.node.detection.period.minutes=-1

# Enable this property to force a compare of old and new data in triggers.  If
# old=new, then don't record the change in the data capture table.
#
# This is currently supported by the following dialects:  mysql, oracle, db2
# DatabaseOverridable: true
# Tags: other
# Type: boolean
trigger.update.capture.changed.data.only.enabled=false

# Disable this property to prevent table triggers from being created before initial load
# has completed.
#
# DatabaseOverridable: true
# Tags: other
# Type: boolean
trigger.create.before.initial.load.enabled=true

# This is a setting that instructs the data capture and data load to
# treat JDBC TIME, DATE, and TIMESTAMP columns as if they were VARCHAR
# columns.  This means that the columns will be captured and loaded in
# the form that the database stores them.  Setting this to true on MySQL
# will allow datetime columns with the value of '0000-00-00 00:00:00' to
# be synchronized.
#
# DatabaseOverridable: true
# Tags: other
# Type: boolean
db.treat.date.time.as.varchar.enabled=false

# This is the expected increment value for the data_id in the data table.
# This is useful if you use auto_increment_increment and auto_increment_offset in MySQL.
# Note that these settings require innodb_autoinc_lock_mode=0, otherwise the increment
# and offset are not guaranteed.
# DatabaseOverridable: true
# Tags: other
data.id.increment.by=1

# Control whether statistics are recorded.
#
# Tags: other
# Type: boolean
# statistic.record.enable=false

# The maximum number of unprocessed outgoing batch rows for a node that will be read
# into memory for the next data extraction.
#
# DatabaseOverridable: true
# Tags: extract
outgoing.batches.max.to.select=50000

# The class name for the Security Service to use for encrypting and
# decrypting database passwords
# Tags: database
security.service.class.name=org.jumpmind.security.SecurityService

# This is a bean shell script that will be used to generate the node id
# for a registering node
# DatabaseOverridable: true
# Type: textbox
# Tags: registration
node.id.creator.script=

# The name of the active log file.  This is used by the system to locate the log file
# for analysis and trouble shooting.  It is set to the default log file location for the
# standalone server.  If deployed as a war file, you should update the value.  Note that
# this property does not change the actual location the log file will be written.  It just
# tells SymmetricDS where to find the log file.
#
# Tags: general
server.log.file=../logs/symmetric.log

# Enables the REST API
#
# DatabaseOverridable: true
# Tags: general
# Type: boolean
rest.api.enable=true