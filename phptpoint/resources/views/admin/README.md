For convenience, I am providing input to the system for browser itself.

The left Part of the page is input section.
You can provide inputs to the controller by clicking on the radio button for each floor.


1. Initially when there is no input from controller, main corridor lights and all ACs are switched on.

2. When there is motion in main corridor, we will be switching off all the lights in sub corridors and switch on AC for both sub corridors. Also we don't have to make any change for main corridor's light AC as they are always on irrespective of any input in the controller.

3. When there is motion in sub corridor1, light and AC for sub corridor1 is switched on and lights and AC for sub-corridor2 is switched off. similar happens when there is motion in sub corridor 2.

4. When there is no motion , it waits for 60 sec and then checks whether the motion has been detected within this 60 second (This is checked by checking the flag status). If there is not motion, the lights for both the sub corridors are switched off and ACs are switched on.

Also i have added Power consumption calculation for each floors.

You need to have apache and PHP installed to examin this code