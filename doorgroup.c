#include <stdio.h>
#include <string.h>

#define BUF_SIZE 1024

int main(int argc, char *argv[])
{
  FILE *fp;
  char linebuf[BUF_SIZE];
  int group_count = 0;
  int group, base;
  int i;

  if (argc < 2)
  { printf("parameter 1: DoorGroup.txt\n"); return 0; }
  fp = fopen(argv[1], "r");
  while (fgets(linebuf, BUF_SIZE, fp) != NULL)
  {
/*    printf("\nlinebuf: %s", linebuf); getchar(); */
    if (strncmp(linebuf, "DoorGroup", 9))
    {
      sscanf(linebuf, "%d", &base);
      for (i = 0;i < 10;i ++)
      {
        if ( *(linebuf+4+i*2) == 'Y' )
        {
	  /*printf(" %d", base+i);*/
	  printf("INSERT INTO door_group (id,door) VALUES (%d,%d);\n", group,base+i);
	}
      }
    }
    else
    {
      sscanf(linebuf+10, "%d", &group);
      /*printf("\nRead group #%d\n", group);*/
      group_count ++;
    }
  }

  fclose(fp);
  return 0;
}

