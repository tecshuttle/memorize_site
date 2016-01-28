<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gallery</title>
    <link rel="stylesheet" href="/css/bootstrap-3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/gallery.css">
</head>

<body>
<div id="Gallery"></div>
</body>

<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/css/bootstrap-3.1.1/js/bootstrap.min.js"></script>
<script src="/js/jQuery-File-Upload/jquery.ui.widget.js"></script>
<script src="/js/jQuery-File-Upload/jquery.fileupload.js"></script>
<script src="/js/react/react.js"></script>
<script src="/js/react/react-dom.js"></script>
<script src="/js/react/browser.min.js"></script>
<script src="/js/gallery/home.js"></script>

<script type="text/babel">
    var GalleryList = React.createClass({
        getInitialState: function() {
          return {
              hide_name: false,
              batch_edit: false,
              tags: null,
              is_list_view: true,
              photo: null,
              GalleryList: null,
              idsSelected: [],
              unSelectList: []
          };
        },

        componentDidMount: function() {
            this._switchTag(0);

            $.post('/gallery/getTags', {}, function(result) {
                if (this.isMounted()) {
                    result.data.unshift({id: 0, tag: '选择分类'});

                    this.setState({
                        tags: result.data
                    });
                }
            }.bind(this), 'json');

            var me = this;

            $('#fileupload').fileupload({
                dataType: 'json',
                add: function (e, data) {
                    data.submit();
                },
                done: function (e, data) {
                    var newData =  me.state.GalleryList;
                    newData.unshift(data.result);

                    me.setState({GalleryList: newData});
                },
                formData: [{
                    name: 'type_id',
                    value: 0
                }],
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    console.log('upload ' + progress + '%');
                    //$('#progress .bar').css('width', progress + '%');
                }
            });
        },

        render: function() {
            var me = this;

            if (! this.state.is_list_view && this.state.photo !== null) {
                var photo = this.state.photo;
                return (
                    <div>
                        <img src={'/uploads/' + photo.download} onDoubleClick={me._onExitBigView}/>
                    </div>
                );
            }

            var list = '';

            if (this.state.GalleryList != null) {
                list = this.state.GalleryList.map(function(d) {
                    var className = 'photo';
                    var selected = (d.selected ? ' selected' : '');
                    className += selected;

                    var hide_name = (me.state.hide_name ? 'hide' : '');
                    var src= '/uploads/thumbnail/' + d.download;

                    return (
                        <div className={className} key={d.id}>
                            <img src={src} onClick={me._onClick.bind(null, d)} onDoubleClick={me._onDoubleClick.bind(null, d)} />
                            <span className={hide_name}>{d.name}</span>
                        </div>
                    );
                });
            }

            var is_selected_hide_file_name = (me.state.hide_name ? 'selected' : '');
            var is_selected_batch_edit = (me.state.batch_edit ? 'selected' : '');

            var option_tag = ''
            if (this.state.tags != null) {
                option_tag = this.state.tags.map(function(t){
                    return (
                        <option value={t.id} key={t.id}>
                           {t.tag}
                        </option>
                    );
                });
            }

            var download_url = '';

            if (this.state.photo !== null && ! this.state.batch_edit) {
                download_url = '/uploads/' + this.state.photo.download;
            }

            var count_selected = '';
            if (this.state.idsSelected.length > 0 && this.state.batch_edit) {
                count_selected = '已选择' + this.state.idsSelected.length + '项';
            }

            return (
                <div>
                    <div id="toolBar" data-spy="affix" data-offset-top="0">
                        <div className="form-inline">
                            <input id="fileupload" className="form-control" type="file" name="files[]" data-url="/gallery/batch_submit" multiple />
                            <button className="form-control" onClick={me._onDelete}>Delete</button>

                            <select className="form-control" onChange={me._onTagChange}>
                                {option_tag}
                            </select>

                            <label>
                               <input type="checkbox" selected={is_selected_hide_file_name} className="form-control" onClick={me._onHideFileName} /> 隐藏文件名
                            </label>

                            <label>
                               <input type="checkbox" selected={is_selected_batch_edit} className="form-control" onClick={me._onBatchEdit} /> 批量编辑
                            </label>

                            <span>{download_url}</span>

                            <span>{count_selected}</span>
                        </div>
                    </div>

                    <div id="GalleryList">{list}</div>
                </div>
            );
        },

        _onClick: function(photo, a, b, c) {
            var me = this;
            var data = this.state.GalleryList;

            if (this.state.batch_edit) {
                //none
            } else {
                console.log('single');
            }

            $.each(data, function(i, p){
                if (photo.id === p.id) {
                    data[i].selected = !data[i].selected;
                } else {
                    if (! me.state.batch_edit) {
                        data[i].selected = false;
                    }
                }
            });

            var ids = [];
            var restData = [];

            //挑出选中的项目
            $.each(this.state.GalleryList, function(i, d){
                if (d.selected) {
                    ids.push(d.id);
                } else {
                    restData.push(d);
                }
            });

            this.setState({
                idsSelected: ids,
                unSelectList: restData
            });

            if (! me.state.batch_edit && ids.length === 1) {
                this.setState({photo: photo});
            } else {
                this.setState({photo: null});
            }

            this.setState({GalleryList: data});
        },

        _onTagChange: function(obj) {
            if (this.state.idsSelected.length > 0) {
                this._moveToTag(obj.target.value)
            } else {
                this._switchTag(obj.target.value);
            }
        },

        _switchTag: function(tag_id) {
            $.post('/gallery/getList', {
                //uid: this.props.uid,
                type_id: tag_id
            }, function(result) {
                if (this.isMounted()) {
                    this.setState({
                        GalleryList: result.data
                    });
                }
            }.bind(this), 'json');
        },

        _moveToTag: function(type_id) {
            var me = this;


            //保存
            $.post('/gallery/moveTo', {
                type_id: type_id,
                ids: me.state.idsSelected.join(',')
            }, function(result) {
                //none
            }.bind(this), 'json');

            this.setState({
                GalleryList: this.state.unSelectList,
                idsSelected: []
            });
        },

        _onDoubleClick: function(photo, a, b, c) {

            this.setState({
                is_list_view: false,
                photo: photo
            });
        },

        _onExitBigView: function(a, b, c) {
            this.setState({
                is_list_view: true
            });
        },

        _onDelete: function(photo, a, b, c) {
            var me = this;

            $.post('/gallery/deleteByids', {
                ids: me.state.idsSelected.join(',')
            }, function(result) {
                //console.log(result);
            }.bind(this), 'json');

            this.setState({GalleryList: this.state.unSelectList});
        },

        _onHideFileName: function() {
            this.setState({hide_name: ! this.state.hide_name});
        },

        _onBatchEdit: function() {
            this.setState({batch_edit: ! this.state.batch_edit});
        }
    });

    ReactDOM.render(
      <GalleryList uid="1" type_id="0" />,
      document.getElementById('Gallery')
    );

</script>

</html>