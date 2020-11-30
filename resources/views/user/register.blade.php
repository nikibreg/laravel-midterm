<form action="{{route('postRegister')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="">
            Email
        </label>
        <input type="email" name="email" class="form-control">
        
        <br>


        <label for="">
            Username
        </label>
        <input type="text" name="name" class="form-control">
        

        <br>
        
        <label for="">
            Password
        </label>
        <input type="password" name="password" class="form-control">

        <br>
        Admin User: <input type="checkbox" name="isAdmin" class="form-control" />
        <br>
        <button type="submit">Register</button>
    </div>
</form>