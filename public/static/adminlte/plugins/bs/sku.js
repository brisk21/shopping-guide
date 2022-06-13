$(".spec-content").on("change",function () {
    sku.createTable();
});
var sku = {
    createTable: function () {
        var specArray = new Array();// 盛放每组选中的CheckBox值的对象
        var titleArray = new Array();// 表格标题数组
        var titleIndex = 0;//规格项目下标
        var columnArray = new Array(); // 指定列，用来合并哪些列
        sku.mergeTable();//合并表格
        //遍历规格
        $(".spec-group").each(function (i, val) {
            columnArray.push(i);
            //checkbox选中的个数
            var checkedLength = $(val).find("input[type=checkbox]:checked").length;
            if (checkedLength > 0) {
                //获取标题
                titleArray[titleIndex] = $(val).attr("spName");
                //规格id
                var spId = $(val).attr("spId");
                //规格名称
                var spName = $(val).attr("spName");
                var specValueArray = new Array();//存放规格值的数组
                //循环,判断获取每个规格中选中的值
                $(val).find("input[type=checkbox]:checked").each(function (j, specVal) {
                    //创建规格对象
                    var specUnit = "";
                    if ($(specVal).attr("flag") == 1) {
                        specUnit = $(specVal).attr("spValueName").trim();
                    }
                    var spec = {
                        spId: spId,
                        spName: spName,
                        specValueId: $(specVal).val().trim(),
                        specValueName: $(specVal).attr("spValueName").trim(),
                        specInfo: spName + ":" + $(specVal).attr("spValueName").trim() + " ",
                        specUnit: specUnit
                    };
                    //将规格值放入数组中
                    specValueArray[j] = spec;
                });
                // 把每个规格的选中项放入数组specArray[arrayLen]
                specArray[titleIndex] = specValueArray;
                titleIndex++
            }
        });
        console.log("规格数组",specArray);
        var arr = sku.getSkuTr(specArray);
        console.log("处理后的数组",arr);
        //开始生成表格
        if (typeof arr != 'undefined') {
            $('#createTable').html('');
            var table = $('<table class="table table-bordered" style="border-collapse: collapse;"></table>');
            table.appendTo($('#createTable'));
            var thead = $('<thead></thead>');
            thead.appendTo(table);
            var trHead = $('<tr></tr>');
            trHead.appendTo(thead);

            //创建表头
            var str = ""
            $.each(titleArray, function (index, item) {
                str += '<th width="10%">' + item + '</th>';
            });
            str += "<th>别名</th><th>售价</th> <th>库存</th><th>规格编码</th>";
            trHead.append(str);
            var tbody = $('<tbody></tbody>');
            tbody.appendTo(table);
            //创建行
            $.each(arr, function (index, item) {
                var specValItem = item.specValueName.split(",");
                var tr = $('<tr name="skuDo" sp-id=' + item.spId + ' sp-name=' + item.spName + ' sp-val-name=' + item.specValueName + ' sp-val-id="' + item.specValueId + '" value="' + item.specValueId + '"></tr>');
                tr.appendTo(tbody);
                var str = '';
                $.each(specValItem, function (i, data) {
                    str += '<td>' + data + '</td>';
                });
                str += '<td>'+ item.specInfo + '</td>';
                str += '<td><input type="number" class="form-control" placeholder="售价"/></td>';
                str += '<td><input type="number" class="form-control" placeholder="库存"/></td>';
                str += '<td><input type="number" class="form-control" placeholder="规格编码"/></td>';
                tr.append(str);
            });

            //结束创建Table表
            columnArray.pop(); //删除数组中最后一项
            //合并单元格
            $(table).mergeCell({
                // 目前只有cols这么一个配置项, 用数组表示列的索引,从0开始
                cols: columnArray
            });
        } else {
            $('#createTable').html('');
        }
    },
    getSkuTr: function (arr) {
        var a = 1;
        for (var r = 0; r < arr.length; r++) {
            a *= arr[r].length;
        }
        var newArray = arr[0]
        for (var m = 1; m < arr.length; m++) {
            var arr2 = arr[m];
            newArray = sku.dosku(newArray, arr2)
        }
        return newArray;
    },
    dosku: function (arr, arr2) {
        var a = arr.length;
        var b = arr2.length;
        var newArr = new Array(a * b);
        var q = 0;
        for (var i = 0; i < arr.length; i++) {
            for (var j = 0; j < arr2.length; j++) {
                var spec = {
                    spId: arr[i].spId + ',' + arr2[j].spId,
                    spName: arr[i].spName + ',' + arr2[j].spName,
                    specValueId: arr[i].specValueId + ',' + arr2[j].specValueId,
                    specValueName: arr[i].specValueName + ',' + arr2[j].specValueName,
                    specUnit: arr[i].specUnit + arr2[j].specUnit,
                    specInfo: arr[i].specInfo + arr2[j].specInfo + " "

                };
                newArr[q] = spec;
                q++;
            }
        }
        return newArr;
    },
    mergeTable: function () {
        $.fn.mergeCell = function (options) {
            return this.each(function () {
                var cols = options.cols;
                for (var i = cols.length - 1; cols[i] != undefined; i--) {
                    mergeCell($(this), cols[i]);
                }
                dispose($(this));
            })
        };

        function mergeCell($table, colIndex) {
            $table.data('col-content', ''); // 存放单元格内容
            $table.data('col-rowspan', 1); // 存放计算的rowspan值 默认为1
            $table.data('col-td', $()); // 存放发现的第一个与前一行比较结果不同td(jQuery封装过的), 默认一个"空"的jquery对象
            $table.data('trNum', $('tbody tr', $table).length); // 要处理表格的总行数, 用于最后一行做特殊处理时进行判断之用
            // 进行"扫面"处理 关键是定位col-td, 和其对应的rowspan
            $('tbody tr', $table).each(function (index) {
                // td:eq中的colIndex即列索引
                var $td = $('td:eq(' + colIndex + ')', this);
                // 获取单元格的当前内容
                var currentContent = $td.html();
                // 第一次时走次分支
                if ($table.data('col-content') == '') {
                    $table.data('col-content', currentContent);
                    $table.data('col-td', $td);
                } else {
                    // 上一行与当前行内容相同
                    if ($table.data('col-content') == currentContent) {
                        // 上一行与当前行内容相同则col-rowspan累加, 保存新值
                        var rowspan = $table.data('col-rowspan') + 1;
                        $table.data('col-rowspan', rowspan);
                        // 值得注意的是 如果用了$td.remove()就会对其他列的处理造成影响
                        $td.hide();
                        // 最后一行的情况比较特殊一点
                        // 比如最后2行 td中的内容是一样的, 那么到最后一行就应该把此时的col-td里保存的td设置rowspan
                        // 最后一行不会向下判断是否有不同的内容
                        if (++index == $table.data('trNum'))
                            $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                    }
                    // 上一行与当前行内容不同
                    else {
                        // col-rowspan默认为1, 如果统计出的col-rowspan没有变化, 不处理
                        if ($table.data('col-rowspan') != 1) {
                            $table.data('col-td').attr('rowspan', $table.data('col-rowspan'));
                        }
                        // 保存第一次出现不同内容的td, 和其内容, 重置col-rowspan
                        $table.data('col-td', $td);
                        $table.data('col-content', $td.html());
                        $table.data('col-rowspan', 1);
                    }
                }
            })
        }

        // 同样是个private函数 清理内存之用
        function dispose($table) {
            $table.removeData();
        }
    }
};