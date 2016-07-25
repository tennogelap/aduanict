<html>

<body>
    <div class="form-group">
        <div class="input-group">
            <table id="mytable">
                <tr>
                    <tr>
                        <td>Member Name</td>
                        <td><input type="text" name="member[]"></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><input type="text" class="textarea" name="address[]"></td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td>
                            <select>
                                <option value="asd">Asd</option>
                                <option value="sda">Sda</option>
                            </select>
                        </td>
                    </tr>
                </tr>
            </table>
        </div>
    </div>

<div>
    <input name="add_table" type='button' id="add_table" value='Add'>
</div>


    <script type="text/javascript">
        $("#add_table").click(function()
        {
            $('#mytable tr').last().after('<tr><td>Member Name</td><td><input type="text" name="member[]"></td></tr><tr><td>Address</td><td><textarea></td></tr><tr><td>Designation</td><td><select><option value="asd">Asd</option><option value="sda">Sda</option></select></td></tr>');
        });
    </script>
</body>
</html>