<div id="profilePopup" style="
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    z-index: 1000;
    width: 350px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
">
    <h4 style="margin-top:0; color:#6b0909;">Edit Profile</h4>

    <form action="{{ route('profile.update.admin') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Profile Image Upload -->
        <div style="text-align:center; margin-bottom:15px;">
            <img id="preview-img" src="{{ asset(Auth::user()->profile_image ?? 'default.jpg') }}" alt="Profile Image" style="width:80px; height:80px; border-radius:50%; object-fit:cover; display:block; margin:auto;">
            <input type="file" name="profile_image" accept="image/*" onchange="previewImage(event)" style="margin-top:10px;">
        </div>

        <!-- Name -->
        <div style="margin-bottom:10px;">
            <label><strong>Name:</strong></label>
            <input type="text" name="name" value="{{ Auth::user()->name }}" style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- Phone -->
        <div style="margin-bottom:10px;">
            <label><strong>Phone:</strong></label>
            <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}" style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- DOB -->
        <div style="margin-bottom:10px;">
            <label><strong>Date of Birth:</strong></label>
            <input type="date" name="dob" value="{{ Auth::user()->date_of_birth }}" style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- Buttons -->
        <div style="text-align:right; margin-top:15px;">
            <button type="submit" style="
                background:#6b0909; color:white; border:none;
                padding:6px 12px; border-radius:4px; cursor:pointer;
            ">Save</button>
            <button type="button" onclick="closeProfilePopup()" style="
                background:#ccc; color:#000; border:none;
                padding:6px 12px; border-radius:4px; cursor:pointer; margin-left:5px;
            ">Cancel</button>
        </div>
    </form>
</div>



<div id="passwordPopup" style="
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    z-index: 1000;
    width: 350px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
">
    <h4 style="margin-top:0; color:#6b0909;">Change Password</h4>

    <form action="{{ route('customer.changePassword.admin') }}" method="POST">
        @csrf
        <!-- Old Password -->
        <div style="margin-bottom:10px;">
            <label><strong>Old Password:</strong></label>
            <input type="password" name="old_password" required style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- New Password -->
        <div style="margin-bottom:10px;">
            <label><strong>New Password:</strong></label>
            <input type="password" name="new_password" required style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom:10px;">
            <label><strong>Confirm Password:</strong></label>
            <input type="password" name="confirm_password" required style="width:100%; padding:6px; border:1px solid #ccc; border-radius:4px;">
        </div>

        <!-- Buttons -->
        <div style="text-align:right; margin-top:15px;">
            <button type="submit" style="
                background:#6b0909; color:white; border:none;
                padding:6px 12px; border-radius:4px; cursor:pointer;
            ">Update</button>
            <button type="button" onclick="closePasswordPopup()" style="
                background:#ccc; color:#000; border:none;
                padding:6px 12px; border-radius:4px; cursor:pointer; margin-left:5px;
            ">Cancel</button>
        </div>
    </form>
</div>
