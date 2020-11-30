<form action="{{route('postLogin')}}" method="post">
    @csrf
    <div class="form-group">
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
        
        <button type="submit">Login</button>
    </div>
</form>
<a href="/users/register">Register</a>