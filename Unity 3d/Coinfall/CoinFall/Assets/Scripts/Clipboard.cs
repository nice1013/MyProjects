using UnityEngine;
using System.Collections;


#if UNITY_ANDROID
public class ClipBoard {
	
	public static void ExportString(string exportData){
		AndroidJavaClass jc = new AndroidJavaClass("com.unity3d.player.UnityPlayer");
		AndroidJavaObject activity = jc.GetStatic<AndroidJavaObject>("currentActivity");
		
		activity.Call("runOnUiThread", new AndroidJavaRunnable(() =>
		                                                       {
			AndroidJavaObject clipboardManager = activity.Call<AndroidJavaObject>("getSystemService","clipboard");
			//clipboardManager.Call("setText", exportData);
			AndroidJavaClass clipDataClass = new AndroidJavaClass("android.content.ClipData");
			AndroidJavaObject clipData = clipDataClass.CallStatic<AndroidJavaObject>("newPlainText","simple text", exportData);
			clipboardManager.Call("setPrimaryClip",clipData);
		}));
	}
}
#endif