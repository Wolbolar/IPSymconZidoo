<?php
// module für Zidoo

class Zidoo extends IPSModule
{

	public function Create()
	{
		//Never delete this line!
		parent::Create();

		//These lines are parsed on Symcon Startup or Instance creation
		//You cannot use variables here. Just static values.

		$this->RegisterPropertyString("host", "");
		$this->RegisterPropertyInteger("port_zidoo", 9529);
	}

	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();

		$this->RegisterVariableBoolean("Status", "Power", "~Switch", 1);
		$this->EnableAction("Status");
		$zidoo_navi_ass = Array(
			Array(0, $this->Translate("Up"), "", -1),
			Array(1, $this->Translate("Left"), "", -1),
			Array(2, $this->Translate("Right"), "", -1),
			Array(3, $this->Translate("Down"), "", -1),
			Array(4, $this->Translate("Ok"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Navigation", "Move", "", "", 0, 4, 0, 0, $zidoo_navi_ass);
		$this->RegisterVariableInteger("ZidooNavigation", $this->Translate("Navigation"), "Zidoo.Navigation", 2);
		$this->EnableAction("ZidooNavigation");
		$zidoo_vol_ass = Array(
			Array(0, $this->Translate("Volume Up"), "", -1),
			Array(1, $this->Translate("Volume Down"), "", -1),
			Array(2, $this->Translate("Mute"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Volume", "Intensity", "", "", 0, 2, 0, 0, $zidoo_vol_ass);
		$this->RegisterVariableInteger("ZidooVolume", $this->Translate("Volume"), "Zidoo.Volume", 3);
		$this->EnableAction("ZidooVolume");
		$zidoo_channel_ass = Array(
			Array(0, $this->Translate("Channel Up"), "", -1),
			Array(1, $this->Translate("Channel Down"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Channel", "Execute", "", "", 0, 1, 0, 0, $zidoo_channel_ass);
		$this->RegisterVariableInteger("ZidooChannel", $this->Translate("Channel"), "Zidoo.Channel", 4);
		$this->EnableAction("ZidooChannel");
		$zidoo_color_ass = Array(
			Array(0, $this->Translate("Red"), "", 16711680),
			Array(1, $this->Translate("Green"), "", 65280),
			Array(2, $this->Translate("Yellow"), "", 16776960),
			Array(3, $this->Translate("Blue"), "", 255)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Color", "Paintbrush", "", "", 0, 3, 0, 0, $zidoo_color_ass);
		$this->RegisterVariableInteger("ZidooColor", $this->Translate("Color"), "Zidoo.Color", 5);
		$this->EnableAction("ZidooColor");
		$zidoo_playback_ass = Array(
			Array(0, $this->Translate("Rewind"), "", -1),
			Array(1, $this->Translate("Pause"), "", -1),
			Array(2, $this->Translate("Play"), "", -1),
			Array(3, $this->Translate("Stop"), "", -1),
			Array(4, $this->Translate("Fast Forward"), "", -1),
			Array(5, $this->Translate("Repeat"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Playback", "Script", "", "", 0, 5, 0, 0, $zidoo_playback_ass);
		$this->RegisterVariableInteger("ZidooPlayback", $this->Translate("Playback"), "Zidoo.Playback", 6);
		$this->EnableAction("ZidooPlayback");
		$zidoo_numeric_ass = Array(
			Array(0, "0", "", -1),
			Array(1, "1", "", -1),
			Array(2, "2", "", -1),
			Array(3, "3", "", -1),
			Array(4, "4", "", -1),
			Array(5, "5", "", -1),
			Array(6, "6", "", -1),
			Array(7, "7", "", -1),
			Array(8, "8", "", -1),
			Array(9, "9", "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Numeric", "Calendar", "", "", 0, 9, 0, 0, $zidoo_numeric_ass);
		$this->RegisterVariableInteger("ZidooNumeric", $this->Translate("Numeric"), "Zidoo.Numeric", 7);
		$this->EnableAction("ZidooNumeric");
		$zidoo_menu_ass = Array(
			Array(0, $this->Translate("Home"), "", -1),
			Array(1, $this->Translate("Menu"), "", -1),
			Array(2, $this->Translate("Audio"), "", -1),
			Array(3, $this->Translate("Subtitle"), "", -1),
			Array(4, $this->Translate("Return"), "", -1),
			Array(5, $this->Translate("Info"), "", -1),
			Array(6, $this->Translate("Mouse"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Menu", "Database", "", "", 0, 6, 0, 0, $zidoo_menu_ass);
		$this->RegisterVariableInteger("ZidooMenu", $this->Translate("Menu"), "Zidoo.Menu", 8);
		$this->EnableAction("ZidooMenu");
		$zidoo_scene_ass = Array(
			Array(0, $this->Translate("Apps"), "", -1),
			Array(1, $this->Translate("Movie"), "", -1),
			Array(2, $this->Translate("Music"), "", -1),
			Array(3, $this->Translate("Photo"), "", -1),
			Array(4, $this->Translate("File Explorer"), "", -1)
		);
		$this->RegisterProfileIntegerAss("Zidoo.Scene", "Popcorn", "", "", 0, 4, 0, 0, $zidoo_scene_ass);
		$this->RegisterVariableInteger("ZidooScene", $this->Translate("Scene"), "Zidoo.Scene", 9);
		$this->EnableAction("ZidooScene");
		$this->ValidateConfiguration();

	}

	/**
	 * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
	 * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
	 *
	 *
	 */

	private function ValidateConfiguration()
	{
		$host = $this->ReadPropertyString('host');

		//check IP
		if (!filter_var($host, FILTER_VALIDATE_IP) === false) {
			//IP ok
			// Status Aktiv
			$this->SetStatus(IS_ACTIVE);
		} else {
			$this->SetStatus(203); //IP Adresse oder Host ist ungültig
		}
	}


	public function RequestAction($Ident, $Value)
	{
		$this->SetValue($Ident, $Value);
		switch ($Ident) {
			case "Status":
				if($Value)
				{
					$this->PowerOn();
				}
				else{
					$this->PowerOff();
				}
				break;
			case "ZidooNavigation":
				if($Value == 0)
				{
					$this->Up();
				}
				elseif($Value == 1)
				{
					$this->Left();
				}
				elseif($Value == 2)
				{
					$this->Right();
				}
				elseif($Value == 3)
				{
					$this->Down();
				}
				elseif($Value == 4)
				{
					$this->Ok();
				}
				break;
			case "ZidooVolume":
				if($Value == 0)
				{
					$this->VolumeUp();
				}
				elseif($Value == 1)
				{
					$this->VolumeDown();
				}
				elseif($Value == 2)
				{
					$this->Mute();
				}
				break;
			case "ZidooChannel":
				if($Value == 0)
				{
					$this->ChannelUp();
				}
				elseif($Value == 1)
				{
					$this->ChannelDown();
				}
				break;
			case "ZidooColor":
				if($Value == 0)
				{
					$this->Red();
				}
				elseif($Value == 1)
				{
					$this->Green();
				}
				elseif($Value == 2)
				{
					$this->Yellow();
				}
				elseif($Value == 3)
				{
					$this->Blue();
				}
				break;
			case "ZidooPlayback":
				if($Value == 0)
				{
					$this->Previous();
				}
				elseif($Value == 1)
				{
					$this->Pause();
				}
				elseif($Value == 2)
				{
					$this->Play();
				}
				elseif($Value == 3)
				{
					$this->Stop();
				}
				elseif($Value == 4)
				{
					$this->Next();
				}
				elseif($Value == 5)
				{
					$this->Repeat();
				}
				break;
			case "ZidooNumeric":
				if($Value == 0)
				{
					$this->Key0();
				}
				elseif($Value == 1)
				{
					$this->Key1();
				}
				elseif($Value == 2)
				{
					$this->Key2();
				}
				elseif($Value == 3)
				{
					$this->Key3();
				}
				elseif($Value == 4)
				{
					$this->Key4();
				}
				elseif($Value == 5)
				{
					$this->Key5();
				}
				elseif($Value == 6)
				{
					$this->Key6();
				}
				elseif($Value == 7)
				{
					$this->Key7();
				}
				elseif($Value == 8)
				{
					$this->Key8();
				}
				elseif($Value == 9)
				{
					$this->Key9();
				}
				break;
			case "ZidooMenu":
				if($Value == 0)
				{
					$this->Home();
				}
				elseif($Value == 1)
				{
					$this->Menu();
				}
				elseif($Value == 2)
				{
					$this->Audio();
				}
				elseif($Value == 3)
				{
					$this->Subtitle();
				}
				elseif($Value == 4)
				{
					$this->Back();
				}
				elseif($Value == 5)
				{
					$this->Info();
				}
				elseif($Value == 6)
				{
					$this->Mouse();
				}
				break;
			case "ZidooScene":
				if($Value == 0)
				{
					$this->AppSwitch();
				}
				elseif($Value == 1)
				{
					$this->Movie();
				}
				elseif($Value == 2)
				{
					$this->Music();
				}
				elseif($Value == 3)
				{
					$this->Photo();
				}
				elseif($Value == 4)
				{
					$this->FileExplorer();
				}
				break;
			default:
				$this->SendDebug("Zidoo", "Invalid ident", 0);
		}
	}

	// Commands

	/**
	 * Menu
	 * @return bool|string
	 */
	public function Menu()
	{
		$command = "Key.Menu"; // menu alternative "Key"
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Back
	 * @return bool|string
	 */
	public function Back()
	{
		$command = "Key.Back"; // back
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Cancel
	 * @return bool|string
	 */
	public function Cancel()
	{
		$command = "Key.Cancel"; // Cancel
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Home
	 * @return bool|string
	 */
	public function Home()
	{
		$command = "Key.Home"; // home
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Up
	 * @return bool|string
	 */
	public function Up()
	{
		$command = "Key.Up"; // up
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Down
	 * @return bool|string
	 */
	public function Down()
	{
		$command = "Key.Down"; // down
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Right
	 * @return bool|string
	 */
	public function Right()
	{
		$command = "Key.Right"; // right
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Left
	 * @return bool|string
	 */
	public function Left()
	{
		$command = "Key.Left"; // left
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Ok
	 * @return bool|string
	 */
	public function Ok()
	{
		$command = "Key.Ok"; // ok
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Select
	 * @return bool|string
	 */
	public function Select()
	{
		$command = "Key.Select"; // select
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Star
	 * @return bool|string
	 */
	public function Star()
	{
		$command = "Key.Star"; // star
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Pound
	 * @return bool|string
	 */
	public function Pound()
	{
		$command = "Key.Pound"; // pound
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Dash
	 * @return bool|string
	 */
	public function Dash()
	{
		$command = "Key.Dash"; // dash
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Media Play
	 * @return bool|string
	 */
	public function Play()
	{
		$command = "Key.MediaPlay"; // play
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Media Stop
	 * @return bool|string
	 */
	public function Stop()
	{
		$command = "Key.MediaStop"; // stop
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Media Pause
	 * @return bool|string
	 */
	public function Pause()
	{
		$command = "Key.MediaPause"; // pause
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Media Next
	 * @return bool|string
	 */
	public function Next()
	{
		$command = "Key.MediaNext"; // next
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Media Previous
	 * @return bool|string
	 */
	public function Previous()
	{
		$command = "Key.PopMenu"; // previous
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Number 0
	 * @return bool|string
	 */
	public function Key0()
	{
		$command = "Key.Number_0"; // 0
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 1
	 * @return bool|string
	 */
	public function Key1()
	{
		$command = "Key.Number_1"; // 1
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 2
	 * @return bool|string
	 */
	public function Key2()
	{
		$command = "Key.Number_2"; // 2
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 3
	 * @return bool|string
	 */
	public function Key3()
	{
		$command = "Key.Number_3"; // 3
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 4
	 * @return bool|string
	 */
	public function Key4()
	{
		$command = "Key.Number_4"; // 4
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 5
	 * @return bool|string
	 */
	public function Key5()
	{
		$command = "Key.Number_5"; // 5
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 6
	 * @return bool|string
	 */
	public function Key6()
	{
		$command = "Key.Number_6"; // 6
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 7
	 * @return bool|string
	 */
	public function Key7()
	{
		$command = "Key.Number_7"; // 7
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 8
	 * @return bool|string
	 */
	public function Key8()
	{
		$command = "Key.Number_8"; // 8
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Number 9
	 * @return bool|string
	 */
	public function Key9()
	{
		$command = "Key.Number_9"; // 9
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Red
	 * @return bool|string
	 */
	public function Red()
	{
		$command = "Key.UserDefine_A"; // red
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Green
	 * @return bool|string
	 */
	public function Green()
	{
		$command = "Key.UserDefine_B"; // green
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Yellow
	 * @return bool|string
	 */
	public function Yellow()
	{
		$command = "Key.UserDefine_C"; // yellow
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Blue
	 * @return bool|string
	 */
	public function Blue()
	{
		$command = "Key.UserDefine_D"; // blue
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Mute
	 * @return bool|string
	 */
	public function Mute()
	{
		$command = "Key.Mute"; // mute
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Volume Up
	 * @return bool|string
	 */
	public function VolumeUp()
	{
		$command = "Key.VolumeUp"; // volume up
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Volume Down
	 * @return bool|string
	 */
	public function VolumeDown()
	{
		$command = "Key.VolumeDown"; // volume down
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Power On
	 * @return bool|string
	 */
	public function PowerOn()
	{
		$command = "Key.PowerOn"; // power
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Backward
	 * @return bool|string
	 */
	public function Backward()
	{
		$command = "Key.MediaBackward"; // backward
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Forward
	 * @return bool|string
	 */
	public function Forward()
	{
		$command = "Key.MediaForward"; // forward
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Info
	 * @return bool|string
	 */
	public function Info()
	{
		$command = "Key.Info"; // info
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Record
	 * @return bool|string
	 */
	public function Record()
	{
		$command = "Key.Record"; // record
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Page up
	 * @return bool|string
	 */
	public function PageUp()
	{
		$command = "Key.PageUP"; // page/chapter up
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Page down
	 * @return bool|string
	 */
	public function PageDown()
	{
		$command = "Key.PageDown"; // page/chapter down
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Subtitle
	 * @return bool|string
	 */
	public function Subtitle()
	{
		$command = "Key.Subtitle"; // subtitle
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Audio
	 * @return bool|string
	 */
	public function Audio()
	{
		$command = "Key.Audio"; // audio
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Repeat
	 * @return bool|string
	 */
	public function Repeat()
	{
		$command = "Key.Repeat"; // repeat
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Mouse
	 * @return bool|string
	 */
	public function Mouse()
	{
		$command = "Key.Mouse"; // mouse
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Popup Menu
	 * @return bool|string
	 */
	public function PopupMenu()
	{
		$command = "Key.PopMenu"; // popup menu
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Movie
	 * @return bool|string
	 */
	public function Movie()
	{
		$command = "Key.movie"; // movie
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Music
	 * @return bool|string
	 */
	public function Music()
	{
		$command = "Key.music"; // music
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Photo
	 * @return bool|string
	 */
	public function Photo()
	{
		$command = "Key.photo"; // photo
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * File Explorer
	 * @return bool|string
	 */
	public function FileExplorer()
	{
		$command = "Key.file"; // file explorer
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * Light
	 * @return bool|string
	 */
	public function Light()
	{
		$command = "Key.light"; // light
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Resolution
	 * @return bool|string
	 */
	public function Resolution()
	{
		$command = "Key.Resolution"; // display mode
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Reboot
	 * @return bool|string
	 */
	public function Reboot()
	{
		$command = "Key.PowerOn.Reboot"; // reboot
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Power Off
	 * @return bool|string
	 */
	public function PowerOff()
	{
		$command = "Key.PowerOn.Poweroff"; // power off
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	/**
	 * Standby
	 * @return bool|string
	 */
	public function Standby()
	{
		$command = "Key.PowerOn.Standby"; // power
		$response = $this->SendCommandtoZidoo($command);
		// more commands

		return $response;
	}

	/**
	 * PIP
	 * @return bool|string
	 */
	public function PIP()
	{
		$command = "Key.Pip"; // pip
		$response = $this->SendCommandtoZidoo($command);
		// more commands

		return $response;
	}


	/**
	 * Screenshot
	 * @return bool|string
	 */
	public function Screenshot()
	{
		$command = "Key.Screenshot"; // screenshot
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}


	/**
	 * App switch
	 * @return bool|string
	 */
	public function AppSwitch()
	{
		$command = "Key.APP.Switch"; // multitasking
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	public function ChannelDown()
	{
		$command = "Key.PageDown"; // channel down
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	public function ChannelUp()
	{
		$command = "Key.PageUP"; // channel up
		$response = $this->SendCommandtoZidoo($command);
		return $response;
	}

	protected function SendCommandtoZidoo($command)
	{
		$ip = $this->ReadPropertyString("host");
		$port_zidoo = $this->ReadPropertyInteger("port_zidoo");
		$data = file_get_contents("http://".$ip.":".$port_zidoo."/ZidooControlCenter/RemoteControl/sendkey?key=".$command);
		$this->SendDebug("Zidoo Send", "http://".$ip.":".$port_zidoo."/ZidooControlCenter/RemoteControl/sendkey?key=".$command, 0);
		$this->SendDebug("Zidoo Response", $data, 0);
		return $data;
	}

	//Profile
	protected function RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $StepSize, $Digits)
	{

		if (!IPS_VariableProfileExists($Name)) {
			IPS_CreateVariableProfile($Name, 1);
		} else {
			$profile = IPS_GetVariableProfile($Name);
			if ($profile['ProfileType'] != 1)
				$this->SendDebug("Zidoo", "Variable profile type does not match for profile " . $Name, 0);
		}

		IPS_SetVariableProfileIcon($Name, $Icon);
		IPS_SetVariableProfileText($Name, $Prefix, $Suffix);
		IPS_SetVariableProfileDigits($Name, $Digits); //  Nachkommastellen
		IPS_SetVariableProfileValues($Name, $MinValue, $MaxValue, $StepSize); // string $ProfilName, float $Minimalwert, float $Maximalwert, float $Schrittweite

	}

	protected function RegisterProfileIntegerAss($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $Stepsize, $Digits, $Associations)
	{
		if (sizeof($Associations) === 0) {
			$MinValue = 0;
			$MaxValue = 0;
		}
		/*
		else {
            //undefiened offset
			$MinValue = $Associations[0][0];
            $MaxValue = $Associations[sizeof($Associations)-1][0];
        }
        */
		$this->RegisterProfileInteger($Name, $Icon, $Prefix, $Suffix, $MinValue, $MaxValue, $Stepsize, $Digits);

		//boolean IPS_SetVariableProfileAssociation ( string $ProfilName, float $Wert, string $Name, string $Icon, integer $Farbe )
		foreach ($Associations as $Association) {
			IPS_SetVariableProfileAssociation($Name, $Association[0], $Association[1], $Association[2], $Association[3]);
		}

	}


	//Add this Polyfill for IP-Symcon 4.4 and older
	protected function SetValue($Ident, $Value)
	{

		if (IPS_GetKernelVersion() >= 5) {
			parent::SetValue($Ident, $Value);
		} else {
			SetValue($this->GetIDForIdent($Ident), $Value);
		}
	}
}