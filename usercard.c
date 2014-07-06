#include <stdio.h>
#include <string.h>

#define BUF_SIZE 1024

int main(int argc, char *argv[])
{
  FILE *fp;
  char linebuf[BUF_SIZE];
  int slot;
  int sn, cn, group;
  char name[64];
  char i;
  char *p;

  if (argc < 2)
  { printf("parameter 1: UserCard.txt\n"); return 0; }
  fp = fopen(argv[1], "r");
  /* skip first line */
  fgets(linebuf, BUF_SIZE, fp);

  while (fgets(linebuf, BUF_SIZE, fp) != NULL)
  {
/*    printf("\nlinebuf: %s", linebuf); getchar(); */
    sscanf(linebuf, "%d", &slot);
    p = strchr(linebuf, ';');
    sscanf(p+1, "%d:%d", &sn, &cn);
    p = strchr(p+1, ';');
    for (i = 0;i < 63 && *(p+i+1) != ';';i ++)
    { name[i] = *(p+i+1); }
    i --;
    while (i >= 0 && name[i] == ' ')
    { i --; } name[i+1] = 0;
    p = strchr(p+1, ';');
    p = strchr(p+1, ';');
    p = strchr(p+1, ';');
    sscanf(p+1, "%d", &group);
    if (cn != 0 || sn != 0)
    {
      /*printf("Slot[%d]: %d:%d GR:%d\n", slot, sn, cn, group);*/
      printf("INSERT INTO card (`address`,`site`,`number`,`user`,`group`) VALUES (%d,%d,%d,'%s',%d);\n", slot,sn,cn,name,group);
    }
  }

  fclose(fp);
  return 0;
}

